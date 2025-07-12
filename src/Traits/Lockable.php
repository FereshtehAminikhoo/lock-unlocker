<?php

namespace LockUnlocker\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;
use LockUnlocker\Models\LockUnlocker;

trait Lockable
{
    public function lockInfo(): HasOne
    {
        return \$this->hasOne(LockUnlocker::class, 'model_id', 'id')
                    ->where('model_name', static::class);
    }

    public function scopeWithLockInfo(\$query)
    {
        return \$query->with(['lockInfo']);
    }

    public function scopeWithCheck(\$query)
    {
        return \$query->whereHas('lockInfo', function (\$q) {
            \$q->where(function (\$q2) {
                \$q2->where('is_lock', false)->orWhereNull('is_lock');
            })->orWhere(function (\$q2) {
                \$q2->whereNull('lock_expired_at')->orWhere('lock_expired_at', '>', now());
            });
        });
    }
}
