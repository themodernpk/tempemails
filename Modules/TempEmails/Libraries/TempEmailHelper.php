<?php
namespace  Modules\TempEmails\Libraries;

use Modules\TempEmails\Entities\TeAccount;
use Modules\TempEmails\Entities\TeStat;

class TempEmailHelper
{

    //---------------------------------------------------------------------
    public static function generateAccount($request, $inbox)
    {

        $insert['inbox'] = $inbox;

        if($request->has('username'))
        {
            $insert['username'] = $request->get('username');
        } else
        {
            $insert['username'] = strtolower(str_random(5));
        }

        $insert['email'] = $insert['username']."@tempemails.io";

        $exist = TeAccount::where('email', $insert['email'])->first();

        if($exist)
        {

            $response['status'] = 'failed';
            $response['errors'][]= "Already Exist";

            return $response;

        }


        $insert['ip'] = $request->ip();

        if(\Auth::user() || $insert['ip'] ==  '103.196.221.19')
        {
            if(\Auth::user())
            {
                $insert['core_user_id'] = \Auth::user()->id;
                $insert['created_by'] = \Auth::user()->id;;
            }
            $insert['hours'] = \Config::get("tempemails.life_span_without_login");

        } else
        {
            $insert['hours'] = \Config::get("tempemails.life_span_with_login");

        }
        $insert['expired_at'] = \Carbon::now()->addHours($insert['hours']);

        $account = TeAccount::create($insert);

        TeStat::create(array('type' => 'account', 'ip'=>$insert['ip']));

        $response['status'] = 'success';
        $response['data'] = $account;

        return $response;
    }
    //---------------------------------------------------------------------
    //---------------------------------------------------------------------
    //---------------------------------------------------------------------
    //---------------------------------------------------------------------
    //---------------------------------------------------------------------
    //---------------------------------------------------------------------
    //---------------------------------------------------------------------
    //---------------------------------------------------------------------


}
