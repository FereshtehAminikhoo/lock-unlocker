<?php

namespace LockUnlocker\Classes;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\DB;
use LockUnlocker\Models\LockUnlocker;
use LockUnlocker\Models\LockUnlockerLog;

class Lock
{
    public static function lock($model_name, $model_id, $creator_name = 'user', $creator_id = null)
    {
        $time = config('lockUnlocker.default_lock_time');
        $lockExpiredAt = Carbon::now()->add(CarbonInterval::make($time));

        $lock = LockUnlocker::updateOrCreate(
            ['model_name' => $model_name, 'model_id' => $model_id],
            [
                'is_lock' => true,
                'lock_expired_at' => $lockExpiredAt,
                'creator_name' => $creator_name,
                'creator_id' => $creator_id,
            ]
        );

        LockUnlockerLog::create([
            'lock_unlocker_id' => $lock->id,
            'model_name'       => $model_name,
            'model_id'         => $model_id,
            'action'           => 'lock',
            'is_lock'          => true,
            'lock_expired_at'  => $lockExpiredAt,
            'creator_name'     => $creator_name,
            'creator_id'       => $creator_id,
        ]);
    }
}
