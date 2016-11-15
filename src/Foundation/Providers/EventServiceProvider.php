<?php

namespace Orchid\Foundation\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Orchid\Foundation\Events\Systems\SettingsEvent' => [
            'Orchid\Foundation\Listeners\Systems\Settings\SettingInfoListener',
            'Orchid\Foundation\Listeners\Systems\Settings\SettingBaseListener',
        ],
        'Orchid\Foundation\Events\Systems\RolesEvent' => [
            'Orchid\Foundation\Listeners\Systems\Roles\RoleBaseListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
