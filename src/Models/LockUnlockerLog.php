<?php

namespace LockUnlocker\Models;

use Illuminate\Database\Eloquent\Model;

class LockUnlockerLog extends Model
{
    protected $table = 'lock_unlocker_logs';

    protected $fillable = [
        'lock_unlocker_id',
        'model_name',
        'model_id',
        'action',
        'is_lock',
        'lock_expired_at',
        'creator_name',
        'creator_id',
    ];

    protected $casts = [
        'is_lock' => 'boolean',
        'lock_expired_at' => 'datetime',
    ];
}
