<?php

namespace Orchid\Platform\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \Orchid\Platform\Events\Systems\RolesEvent::class => [
            \Orchid\Platform\Listeners\Systems\Roles\RoleBaseListener::class,
        ],
        \Orchid\Platform\Events\Systems\UserEvent::class  => [
            \Orchid\Platform\Listeners\Systems\Users\UserBaseListener::class,
            \Orchid\Platform\Listeners\Systems\Users\UserAccessListener::class,
        ],
        \Illuminate\Auth\Events\Login::class              => [
            \Orchid\Platform\Listeners\Systems\Users\LogSuccessfulLogin::class,
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
