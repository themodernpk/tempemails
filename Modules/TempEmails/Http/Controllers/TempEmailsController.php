<?php

namespace Modules\TempEmails\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\TempEmails\Entities\TeAccount;
use Modules\TempEmails\Entities\TeMail;
use Modules\TempEmails\Entities\TeStat;

class TempEmailsController extends Controller
{
    public $data;

    function __construct( Request $request ) {
        $this->data                      = new \stdClass();
    }

    //-----------------------------------------------------------
    public function index(Request $request)
    {
        $this->data->title = "Temporary Disposable Email Accounts";
        $this->data->username = strtolower(str_random(5));
        return view( "tempemails::pages.index" )
            ->with( "data", $this->data );
    }

    //-----------------------------------------------------------
    public function checkCookies(Request $request)
    {
        $inbox = $request->cookie('inbox');

        if(!$inbox)
        {
            $inbox = uniqid();
        }
        return redirect()->route('te.apps', [$inbox])->withCookie(cookie()->forever('inbox', $inbox));
    }
    //-----------------------------------------------------------
    public function apps(Request $request, $inbox)
    {
        $this->data->title = "Temporary Accounts";
        $this->data->inbox = $inbox;

        return view( "tempemails::pages.app" )
            ->with( "data", $this->data );
    }
    //-----------------------------------------------------------
    public function accounts(Request $request, $inbox)
    {
        $this->data->title = "Temporary Accounts";
        return view( "tempemails::pages.accounts" )
            ->with( "data", $this->data );
    }
    //-----------------------------------------------------------
    public function accountList(Request $request, $inbox)
    {
        $list = TeAccount::select('id', 'inbox', 'username', 'email', 'hours', 'created_at')->where('inbox', $inbox);
        $list->withCount('unreadMails');

        $list->orderBy('created_at', 'DESC');
        $response['data'] = $list->get();
        $response['status'] = 'success';
        return response()->json($response);

    }
    //-----------------------------------------------------------
    public function emailList(Request $request, $inbox)
    {
        $rules = array(
            'te_account_id' => 'required',
        );

        $messages = array(
            'te_account_id.required' => 'Select the emails account first',
        );

        $validator = \Validator::make( $request->toArray(), $rules, $messages);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;

            return response()->json($response);
        }
        $list = TeMail::where('te_account_id', $request->get('te_account_id'));
        $list->select('id', 'subject', 'read', 'received_at');
        $list->with(['from', 'to', 'cc', 'attachments']);
        $list->orderBy('received_at', 'DESC');

        $response['syncMessages'] = TeAccount::syncMessages($request);

        $response['data'] = $list->paginate(10);
        $response['status'] = 'success';
        return response()->json($response);
    }
    //-----------------------------------------------------------
    public function emailDetails(Request $request, $inbox)
    {
        $rules = array(
            'id' => 'required',
        );

        $messages = array(
            'id.required' => 'Select the emails subject first',
        );

        $validator = \Validator::make( $request->toArray(), $rules, $messages);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;

            return response()->json($response);
        }

        $list = TeMail::where('id', $request->get('id'));
        $list->with(['from', 'to', 'cc', 'attachments']);

        $item = $list->first();
        $item->read = 1;
        $item->save();
        $response['data'] = $item;
        $response['data']['formatted'] = $response['data']->formattedHtml();

        $response['status'] = 'success';
        return response()->json($response);
    }
    //-----------------------------------------------------------
    public function emailiFrame(Request $request, $encrypted_id)
    {
        $id = \Crypt::decrypt($encrypted_id);
        $list = TeMail::where('id', $id);
        $list->select(['message']);
        $response = $list->first();
        return response($response->message, 200);
    }
    //-----------------------------------------------------------
    public function generateAccount(Request $request, $inbox)
    {
        $insert['inbox'] = $inbox;
        $insert['username'] = strtolower(str_random(5));
        $insert['email'] = $insert['username']."@tempemails.io";

        $insert['ip'] = $request->ip();

        if(\Auth::user() || $insert['ip'] ==  '103.196.221.19')
        {
            if(\Auth::user())
            {
                $insert['core_user_id'] = \Auth::user()->id;
                $insert['created_by'] = \Auth::user()->id;;
            }
            $insert['hours'] = 168;
        } else
        {
            $insert['hours'] = 24;
        }


        $account = TeAccount::create($insert);

        TeStat::create(array('type' => 'account', 'ip'=>$insert['ip']));

        $response['status'] = 'success';
        $response['data'] = $account;
        return response()->json($response);
    }
    //-----------------------------------------------------------
    public  function deleteAccount(Request $request, $inbox)
    {
        $rules = array(
            'id' => 'required',
        );

        $messages = array(
            'id.required' => 'Click on account delete button',
        );

        $validator = \Validator::make( $request->toArray(), $rules, $messages);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $account = TeAccount::find($request->get('id'));

        if(!$account)
        {
            $response['status'] = 'failed';
            $response['errors'][]= 'Account does not';
            return response()->json($response);
        }

        $account->delete();

        $response['status'] = 'success';
        return response()->json($response);
    }
    //-----------------------------------------------------------
    public function markAllAsRead(Request $request, $inbox)
    {
        $rules = array(
            'id' => 'required',
        );

        $messages = array(
            'id.required' => 'Click on trash icon to delete account'
        );

        $validator = \Validator::make( $request->toArray(), $rules, $messages);
        if ( $validator->fails() ) {
            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        TeMail::where('te_account_id', $request->get('id'))->update(['read' => 1]);

        $response['status'] = 'success';
        return response()->json($response);
    }
    //-----------------------------------------------------------
    public function deleteAllEmails(Request $request, $inbox)
    {
        $rules = array(
            'id' => 'required',
        );

        $messages = array(
            'id.required' => 'Click on trash icon to delete emails'
        );

        $validator = \Validator::make( $request->toArray(), $rules, $messages);
        if ( $validator->fails() ) {
            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        TeMail::where('te_account_id', $request->get('id'))->delete();

        $response['status'] = 'success';
        return response()->json($response);
    }
    //-----------------------------------------------------------
    //-----------------------------------------------------------
    //-----------------------------------------------------------

}
