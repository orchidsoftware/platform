<?php

namespace Orchid\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \Orchid\Events\Systems\RolesEvent::class         => [
            \Orchid\Listeners\Systems\Roles\RoleBaseListener::class,
        ],
        \Orchid\Events\Systems\UserEvent::class          => [
            \Orchid\Listeners\Systems\Users\UserBaseListener::class,
            \Orchid\Listeners\Systems\Users\UserAccessListener::class,
        ],
        \Illuminate\Auth\Events\Login::class => [
            \Orchid\Listeners\Systems\Users\LogSuccessfulLogin::class,
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
