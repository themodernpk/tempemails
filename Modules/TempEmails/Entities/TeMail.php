<?php

namespace Modules\TempEmails\Entities;

use DOMDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeMail extends Model
{
    use SoftDeletes;

    //-------------------------------------------------
    protected $table = 'te_mails';
    //-------------------------------------------------
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------

    protected $fillable = [
        'te_account_id', 'received_at', 'received_at', 'uid', 'subject',
        'message', 'message_text', 'message_raw',
        'meta', 'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

    //-------------------------------------------------
    protected $appends  = [
        'iframe',
    ];
    //-------------------------------------------------

    public function getIframeAttribute()
    {
        $encrypted_id = \Crypt::encrypt($this->id);
        $iframe = \URL::route('te.email.iframe', [$encrypted_id]);
        return $this->attributes['iframe']=$iframe;
    }

    //-------------------------------------------------
    public function formattedHtml()
    {


        $dom = new DOMDocument();
        // we want nice output
        $dom->preserveWhiteSpace = false;
        $dom->loadHTML($this->message);
        $dom->formatOutput = true;
        $format = new \Format();



        return $format->HTML($this->message);;
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
    public function account() {
        return $this->belongsTo( 'Modules\TempEmails\Entities\TeAccount',
                                 'te_account_id', 'id'
        );
    }
    //-------------------------------------------------
    public function contacts() {
        return $this->hasMany( 'Modules\TempEmails\Entities\TeContact',
                                     'te_mail_id', 'id');
    }
    //-------------------------------------------------
    public function from()
    {
        return $this->contacts()->where('type', 'from');
    }
    //-------------------------------------------------

    //-------------------------------------------------
    public function to()
    {
        return $this->contacts()->where('type', 'to');
    }
    //-------------------------------------------------
    public function cc()
    {
        return $this->contacts()->where('type', 'cc');
    }
    //-------------------------------------------------
    public function attachments() {
        return $this->hasMany( 'Modules\TempEmails\Entities\TeMailAttachment',
                               'te_mail_id', 'id');
    }
    //-------------------------------------------------
    protected static function boot() {
        parent::boot();

        static::deleting(function($check) {
            $check->contacts()->delete();
            $check->attachments()->delete();
        });
    }
    //-------------------------------------------------
    //-------------------------------------------------
}
