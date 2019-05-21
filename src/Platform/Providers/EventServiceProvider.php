<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Auth\Events\Login;
use Orchid\Platform\Listeners\LockUserForLogin;
use Orchid\Platform\Listeners\LogSuccessfulLogin;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Login::class => [
            LogSuccessfulLogin::class,
            LockUserForLogin::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();
    }
}
