<?php

namespace Modules\TempEmails\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Libraries\Date;
use Modules\TempEmails\Events\NewEmail;

class TeAccount extends Model
{
    use SoftDeletes;

    //-------------------------------------------------
    protected $table = 'te_accounts';
    //-------------------------------------------------
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at', 'expired_at'
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------

    protected $fillable = [
        'core_user_id', 'inbox', 'username', 'email',
        'hours', 'ip', 'expired_at', 'expired',
        'created_by', 'updated_by', 'deleted_by',
    ];

    //-------------------------------------------------
    protected $appends  = [
        'remaining_time',
    ];
    //-------------------------------------------------

    //-------------------------------------------------
    public function getRemainingTimeAttribute()
    {
        return $this->attributes['remaining_time']= \Carbon::parse($this->expired_at)->diffForHumans();
    }
    //-------------------------------------------------
    public function scopeCreatedBy($query, $user_id)
    {
        return $query->where('created_by', $user_id);
    }
    //-------------------------------------------------
    public function scopeUpdatedBy($query, $user_id)
    {
        return $query->where('updated_by', $user_id);
    }
    //-------------------------------------------------
    public function scopeDeletedBy($query, $user_id)
    {
        return $query->where('deleted_by', $user_id);
    }
    //-------------------------------------------------
    public function scopeCreatedBetween($query, $from, $to)
    {
        return $query->whereBetween('created_at', array($from, $to));
    }
    //-------------------------------------------------
    public function scopeUpdatedBetween($query, $from, $to)
    {
        return $query->whereBetween('updated_at', array($from, $to));
    }
    //-------------------------------------------------
    public function scopeDeletedBetween($query, $from, $to)
    {
        return $query->whereBetween('deleted_at', array($from, $to));
    }
    //-------------------------------------------------
    public function createdBy() {
        return $this->belongsTo( 'Modules\Core\Entities\User',
                                 'created_by', 'id'
        );
    }
    //-------------------------------------------------
    public function updatedBy() {
        return $this->belongsTo( 'Modules\Core\Entities\User',
                                 'updated_by', 'id'
        );
    }
    //-------------------------------------------------
    public function deletedBy() {
        return $this->belongsTo( 'Modules\Core\Entities\User',
                                 'deleted_by', 'id'
        );
    }
    //-------------------------------------------------
    public function mails() {
        return $this->hasMany( 'Modules\TempEmails\Entities\TeMail',
                                 'te_account_id', 'id'
        );
    }
    //-------------------------------------------------
    public function unreadMails()
    {
        return $this->mails()->whereNull('read');
    }
    //-------------------------------------------------
    protected static function boot() {
        parent::boot();

        static::deleting(function($check) {
            $check->mails()->delete();
        });
    }
    //-------------------------------------------------
    public static function syncMessages($request)
    {

        $inbox_config['hostname']= env('IMAP_HOST');
        $inbox_config['email']= env('IMAP_EMAIL');
        $inbox_config['password']= env('IMAP_PASSWORD');
        $inbox_config['upload_path']= 'files/attachments';

        $mailbox = new \PhpImap\Mailbox($inbox_config['hostname'], $inbox_config['email'],
                                        $inbox_config['password'], $inbox_config['upload_path']);

        $sync_from = date('d F Y');
        $mailUIDs = $mailbox->searchMailBox('SINCE "'.$sync_from.'"', SE_UID);
        //$mailUIDs = $mailbox->searchMailBox('UNSEEN', SE_UID);

        foreach ($mailUIDs as $uid)
        {

            $message = TeMail::where('uid', $uid)
                ->withTrashed()
                ->first();

            if($message)
            {
                continue;
            }

            //quick create the mail entry so that duplicate will not be process
            $message = TeMail::create(array('uid' => $uid));


            //$mail = $mailbox->getMail(5);
            $mail = $mailbox->getMail($uid);

            //get contacts
            $from = [];
            $to = [];
            $cc = [];


            if(isset($mail->headers->from)) $from = TeAccount::mailboxToContacts($mail->headers->from, 'from');
            if(isset($mail->headers->to)) $to = TeAccount::mailboxToContacts($mail->headers->to, 'to');
            if(isset($mail->headers->cc)) $cc = TeAccount::mailboxToContacts($mail->headers->cc, 'cc');


            $insert['contacts'] = array_merge($from, $to, $cc);
/*            echo "<pre>";
            print_r($insert);
            echo "</pre>";
            die("<hr/>line number=123");*/


            if(!is_array($to))
            {
                continue;
            }

            //create account
            foreach ($to as $account_item)
            {
                if (strpos($account_item['email'], 'tempemails.io') !== false) {
                    //check if account exist
                    $account = TeAccount::where('email', $account_item['email'])->withTrashed()->first();

                    if(!$account)
                    {
                        if (\Auth::user())
                        {
                            $account_insert['core_user_id'] = \Auth::user()->id;
                        }
                        $account_d = explode("@", $account_item['email']);
                        $account_insert['username'] = $account_d[0];
                        $account_insert['email'] = $account_item['email'];
                        $account_insert['hours'] = \Config::get("tempemails.life_span_without_login");
                        if (\Auth::user())
                        {
                            $account_insert['hours'] = \Config::get("tempemails.life_span_with_login");
                        }
                        $insert['expired_at'] = \Carbon::now()->addHours($account_insert['hours']);
                        $account_insert['ip'] = $request->ip();

                        if (\Auth::user())
                        {
                            $account_insert['created_by'] = Auth::user()->id;
                        }
                        $account = TeAccount::create($account_insert);
                    }


                }
            }


            $insert['message']['te_account_id'] = $account->id;
            //$insert['message']['uid'] = $uid;

            $insert['message']['received_at'] = $mail->date;
            $insert['message']['subject'] = $mail->subject;
            $insert['message']['message'] =  \Purify::clean($mail->textHtml);
            $insert['message']['message_text'] = $mail->textPlain;
            $insert['message']['message_raw'] = $mail->headersRaw;
            $insert['message']['meta'] = json_encode($mail->headersRaw);

            $message->fill($insert['message']);
            $message->save();

            TeStat::create(array('type' => 'email', 'ip'=>$request->ip()));

            //$message = TeMail::create($insert['message']);
            $response['message'][] = 'ID '.$message->id." email is created";


            //save and attach the contacts
            foreach ($insert['contacts'] as $contact)
            {
                $contact['te_mail_id'] = $message->id;
                $find_contact = TeContact::create($contact);
            }

            TeAccount::saveAttachments($mail->getAttachments(), $message->id);
            event(new NewEmail($account->id, $message->id));
        }

        $response['status'] = 'success';

        return $response;
    }

    //-------------------------------------------------
    public static function mailboxToContacts($arr, $type)
    {

        if(count($arr) < 1 || empty($arr))
        {
            return array();
        }

        $i = 0;
        $result = array();
        foreach ($arr as $item)
        {

            if(!isset($item->host) || $item->mailbox == 'undisclosed-recipients')
            {
                continue;
            }

            $result[$i]['type'] = $type;
            if(isset($item->personal) && $item->personal != "")
            {
                $result[$i]['name'] = $item->personal;
            }
            $result[$i]['email'] = $item->mailbox."@".$item->host;

            $i++;
        }

        return $result;
    }
    //-------------------------------------------------
    public static function saveAttachments($attachments, $message_id)
    {

        if(!$attachments)
        {
            return false;
        }

        foreach ($attachments as $attachment)
        {
            //check if attachment exist
            $exist = TeMailAttachment::where('te_mail_id', $message_id)
                ->where('name', $attachment->name)->first();
            if($exist)
            {
                continue;
            }

            $insert = [];
            $insert['te_mail_id'] = $message_id;
            $insert['name'] = $attachment->name;

            $upload_d = explode('files\attachments\\', $attachment->filePath);

            if(!isset($upload_d[1]))
            {
                $upload_d = explode('/files/attachments/', $attachment->filePath);
            }

            $uploaded_url = \URL::to('/')."/files/attachments/".$upload_d[1];

            $insert['url'] = $uploaded_url;

            TeMailAttachment::create($insert);

        }


    }
    //-------------------------------------------------
    public static function checkExpiryIsNull()
    {
        $exist = TeAccount::whereNull('expired_at')->exists();

        if(!$exist)
        {
            $response['status'] = 'success';
            $response['message'][]= 'No Account is Expired';
            return $response;
        }
        $list = TeAccount::whereNull('expired_at')->get();

        foreach ($list as $account)
        {
            $account->expired_at = $account->created_at->addHours($account->hours);
            $account->save();
        }

        $response['status'] = 'success';
        $response['message'][]= 'Expire date are set';
        return $response;

    }
    //-------------------------------------------------
    public static function checkExpiry()
    {

        $now = \Carbon::now();
        $date_time = $now->format('Y-m-d H:i:s');
        $expired = TeAccount::where('expired_at', '<', $date_time)->whereNull('expired')->exists();

        if(!$expired)
        {
            $response['status'] = 'success';
            $response['message'][]= 'No Account is Expired';
            return $response;
        }

        $expired = TeAccount::where('expired_at', '<', $date_time)->whereNull('expired')->update(['expired' => 1]);

        $response['status'] = 'success';
        $response['message'][]= $expired.' Accounts are marked as expired';
        return $response;

    }
    //-------------------------------------------------
    public static function deleteExpiredAccounts()
    {
        //find expired account passed 7 days
        $date = \Carbon::now()->subDays(7)->format("Y-m-d");

        $expired_accounts = TeAccount::withTrashed()->where('expired', 1)
            ->where('expired_at', '<', $date)
            ->get();

        if(!$expired_accounts)
        {
            $response['status'] = 'failed';
            $response['errors'][]= 'No account is expired';
            return $response;
        }

        if($expired_accounts)
        {
            foreach ($expired_accounts as $account)
            {
                TeAccount::deleteAccount($account->id);
            }
        }

        $response['status'] = 'success';
        return $response;
    }
    //-------------------------------------------------
    public static function deleteAccount($id)
    {

        $account = TeAccount::withTrashed()->where('id', $id)->first();
        if(!$account)
        {
            $response['status'] = 'failed';
            $response['errors'][]= 'Account not exist';
            return $response;
        }


        //check if mails exist
        if($account->mails()->exists() > 0)
        {
           foreach ($account->mails()->get() as $mail)
           {
               TeMail::deleteMail($mail->id);
           }
        }

        $account->delete();
        $response['status'] = 'failed';
        $response['messages'][]= 'Account deleted';
        return $response;

    }
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
}
