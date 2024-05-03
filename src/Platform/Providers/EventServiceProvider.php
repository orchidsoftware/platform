<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Orchid\Platform\Listeners\LockUserForLogin;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Login::class => [
            LockUserForLogin::class,
        ],
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        if (isset(static::$shouldDiscoverEvents)) {
            return get_class($this) === __CLASS__ && static::$shouldDiscoverEvents === true;
        }

        return parent::shouldDiscoverEvents();
    }
}
