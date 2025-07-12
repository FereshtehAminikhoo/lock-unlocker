<?php

namespace LockUnlocker;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class LockUnlockerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        \$this->loadMigrationsFrom(__DIR__.'/../migrations');
        \$this->mergeConfigFrom(__DIR__.'/../config/lockUnlocker.php', 'lockUnlocker');

        \$this->publishes([
            __DIR__.'/../config/lockUnlocker.php' => config_path('lockUnlocker.php'),
        ], 'lock-unlocker-config');

        \$this->publishes([
            __DIR__.'/../migrations' => database_path('migrations'),
        ], 'lock-unlocker-migrations');

        Builder::macro('withCheck', function () {
            return \$this->where(function (\$q) {
                \$q->where('is_lock', false)->orWhereNull('is_lock');
            })->where(function (\$q) {
                \$q->whereNull('lock_expired_at')->orWhere('lock_expired_at', '>', now());
            });
        });
    }
}
