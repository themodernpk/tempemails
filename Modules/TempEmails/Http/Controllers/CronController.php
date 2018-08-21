<?php

namespace Modules\TempEmails\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\TempEmails\Entities\TeAccount;
use Modules\TempEmails\Entities\TeMail;
use PhpImap\Mailbox as ImapMailbox;
use PhpImap\IncomingMail;
use PhpImap\IncomingMailAttachment;


class CronController extends Controller
{
    //------------------------------------------------
    public function perMinute(Request $request)
    {
        $response['syncMessages'] = TeAccount::syncMessages($request);
        //$response['deleteExpiredAccounts'] = TeAccount::deleteExpiredAccounts(10);
        return response()->json($response);
    }
    //------------------------------------------------
    public function perHour(Request $request)
    {
        $response['checkExpiryIsNull'] = TeAccount::checkExpiryIsNull($request);
        $response['checkExpiry'] = TeAccount::checkExpiry($request);

        $response['deleteExpiredAccounts'] = TeAccount::deleteExpiredAccounts(50);

        return response()->json($response);
    }
    //------------------------------------------------
    public function perDay()
    {
        $response['deleteExpiredAccounts'] = TeAccount::deleteExpiredAccounts();

        return response()->json($response);
    }
    //------------------------------------------------
    public function authPusher(Request $request)
    {
        $pusher = new \Pusher( '3ee8efc1b5ea9de4411b', 'dd4060a89d36498c3920', '321737' );
        echo $pusher->presence_auth($request->get('channel_name'), $request->get('socket_id'), 1);
    }
    //------------------------------------------------
    public function cleanDatabase(Request $request)
    {

        die("<hr/>line number=123");
        if($request->has('action'))
        {

            echo $request->get('action');
            echo "<hr/>";
            switch ($request->get('action'))
            {
                case 'truncate':
                    \DB::table('te_mail_attachments')->truncate();
                    \DB::table('te_mails')->truncate();
                    \DB::table('te_contacts')->truncate();
                    \DB::table('te_accounts')->truncate();
                    break;

            }

        }

        $response['status'] = 'success';
        return response()->json($response);


    }
    //------------------------------------------------
    //------------------------------------------------
}
