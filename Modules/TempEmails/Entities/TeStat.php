<?php

namespace Modules\TempEmails\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeStat extends Model
{
    use SoftDeletes;

    //-------------------------------------------------
    protected $table = 'te_stats';
    //-------------------------------------------------
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------

    protected $fillable = [
        'type', 'ip',
        'created_by', 'updated_by', 'deleted_by',
    ];

    //-------------------------------------------------
    protected $appends  = [
    ];
    //-------------------------------------------------

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
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
}
