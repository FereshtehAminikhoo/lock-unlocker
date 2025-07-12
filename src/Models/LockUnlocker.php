<?php

namespace LockUnlocker\Models;

use Illuminate\Database\Eloquent\Model;

class LockUnlocker extends Model
{
    protected $table = 'lock_unlockers';

    protected $fillable = [
        'model_name',
        'model_id',
        'is_lock',
        'lock_expired_at',
        'creator_name',
        'creator_id',
    ];

    protected $casts = [
        'is_lock' => 'boolean',
        'lock_expired_at' => 'datetime',
    ];

    public function logs()
    {
        return \$this->hasMany(LockUnlockerLog::class, 'lock_unlocker_id');
    }
}
