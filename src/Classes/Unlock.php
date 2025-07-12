<?php

namespace LockUnlocker\Classes;

use Illuminate\Support\Facades\DB;
use LockUnlocker\Models\LockUnlocker;
use LockUnlocker\Models\LockUnlockerLog;

class Unlock
{
    public static function unlock($model_name, $model_id, $creator_name = 'user', $creator_id = null)
    {
        $lock = LockUnlocker::where('model_name', $model_name)
                            ->where('model_id', $model_id)
                            ->first();

        if ($lock) {
            $lock->update([
                'is_lock' => false,
                'lock_expired_at' => null,
                'creator_name' => $creator_name,
                'creator_id' => $creator_id,
            ]);

            LockUnlockerLog::create([
                'lock_unlocker_id' => $lock->id,
                'model_name'       => $model_name,
                'model_id'         => $model_id,
                'action'           => 'unlock',
                'is_lock'          => false,
                'lock_expired_at'  => null,
                'creator_name'     => $creator_name,
                'creator_id'       => $creator_id,
            ]);
        }
    }
}
