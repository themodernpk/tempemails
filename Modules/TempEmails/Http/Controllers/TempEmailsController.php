<?php

namespace Modules\TempEmails\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Jenssegers\Agent\Agent;

use Modules\Core\Entities\User;
use Modules\TempEmails\Entities\TeAccount;
use Modules\TempEmails\Entities\TeMail;
use Modules\TempEmails\Entities\TeStat;
use Modules\TempEmails\Libraries\TempEmailHelper;

class TempEmailsController extends Controller
{
    public $data;

    function __construct( Request $request ) {
        $this->data                      = new \stdClass();
    }

    //-----------------------------------------------------------
    public function index(Request $request)
    {
        $this->data->title = "TempEmails.io | Free Temporary Disposable Email | Developer Tool";
        $this->data->description = "TempEmails.io is a tool to Temporary Disposable Emails with a click. No registration is required. It can help developer to debug the transactional emails and others can use theses temporary to register on other website to avoid spam.";

        $this->data->accounts = TeStat::where('type', 'account')->count();
        $this->data->emails = TeStat::where('type', 'email')->count();
        $this->data->agent = new Agent();

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

        $response = TempEmailHelper::generateAccount($request, $inbox);

        return redirect()->route('te.apps', [$inbox])->withCookie(cookie()->forever('inbox', $inbox));
    }
    //-----------------------------------------------------------
    public function stats(Request $request)
    {
        $response['data']['count']['emails'] = TeStat::where('type', 'account')->count();
        $response['data']['count']['accounts'] = TeStat::where('type', 'email')->count();
        $response['status'] = 'success';
        return response()->json($response);
    }
    //-----------------------------------------------------------
    public function apps(Request $request, $inbox)
    {

        $this->data->title = "TempEmails.io | Free Temporary Disposable Email | Developer Tool";
        $this->data->inbox = $inbox;

        return view( "tempemails::pages.app" )
            ->with( "data", $this->data );
    }
    //-----------------------------------------------------------
    public function accounts(Request $request, $inbox)
    {
        $this->data->title = "TempEmails.io | Free Temporary Disposable Email | Developer Tool";
        return view( "tempemails::pages.accounts" )
            ->with( "data", $this->data );
    }
    //-----------------------------------------------------------
    public function accountList(Request $request, $inbox)
    {
        $list = TeAccount::select('id', 'inbox', 'username', 'email', 'expired_at', 'expired', 'created_at')
            ->where('inbox', $inbox);
        $list->withCount('unreadMails');
        $list->withCount('mails');

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

        $message = $response->formattedHtml();
        return response($message, 200);
    }
    //-----------------------------------------------------------
    public function generateAccount(Request $request, $inbox)
    {

        $response = TempEmailHelper::generateAccount($request, $inbox);

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

        $list = TeMail::select('id', 'te_account_id')->where('te_account_id', $request->get('id'))
            ->withTrashed()->get();

        if($list)
        {
            foreach ($list as $item)
            {
                TeMail::deleteMail($item->id);
            }
        }

        $response['status'] = 'success';
        return response()->json($response);
    }
    //-----------------------------------------------------------
    public function notifyAdmin(Request $request)
    {
        $rules = array(
            'email' => 'required|email',
            'category' => 'required',
            'message' => 'required',
        );

        $validator = \Validator::make( $request->toArray(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;

            if ($request->ajax()) {
                return response()->json($response);
            } else {
                return redirect()->back()->withInput()->withErrors($errors);
            }
        }

        $subject = "[TempEmail.io] ".$request->get('email')." | Category: ".$request->get('category');
        $message = $request->get('message');


        try{
            User::notifyAdmins($subject, $message);
            $response['status'] = 'success';

        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
        }

        return response()->json($response);

    }
    //-----------------------------------------------------------
    //-----------------------------------------------------------

}
