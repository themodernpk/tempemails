<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    //-------------------------------------------------
    protected $table = 'core_notifications';
    //-------------------------------------------------
    protected $dates = [
        'created_at', 'updated_at'
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------

    protected $fillable = [
        'type', 'label', 'core_user_id', 'title', 'details',
        'link', 'meta', 'read_at',
    ];

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
    public function send()
    {
        //store in database

        //attempt to deliver the email else mark status to queued

    }
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
}
