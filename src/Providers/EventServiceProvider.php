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

        \Orchid\Platform\Events\SettingsEvent::class => [
            \Orchid\Platform\Listeners\Settings\SettingInfoListener::class,
            \Orchid\Platform\Listeners\Settings\SettingBaseListener::class,
            \Orchid\Platform\Listeners\Settings\SettingPhpInfoListener::class,
        ],
        \Orchid\Platform\Events\CategoryEvent::class   => [
            \Orchid\Platform\Listeners\Category\CategoryBaseLister::class,
            \Orchid\Platform\Listeners\Category\CategoryDescLister::class,
        ],
        \Orchid\Platform\Events\CommentEvent::class    => [
            \Orchid\Platform\Listeners\Comment\CommentBaseListener::class,
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
