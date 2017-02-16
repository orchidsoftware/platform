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
        'Orchid\Foundation\Events\Systems\UserEvent' => [
            'Orchid\Foundation\Listeners\Systems\Users\UserBaseListener',
            'Orchid\Foundation\Listeners\Systems\Users\UserAccessListener',
        ],
        'Orchid\Foundation\Events\Tools\CategoryEvent' => [
            'Orchid\Foundation\Listeners\Tools\Category\CategoryBaseLister',
        ],

        'Orchid\Foundation\Events\Marketing\CommentEvent' => [
            'Orchid\Foundation\Listeners\Marketing\Comment\CommentBaseListener',
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
