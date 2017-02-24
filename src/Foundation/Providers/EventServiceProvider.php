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
        \Orchid\Foundation\Events\Systems\SettingsEvent::class => [
            \Orchid\Foundation\Listeners\Systems\Settings\SettingInfoListener::class,
            \Orchid\Foundation\Listeners\Systems\Settings\SettingBaseListener::class,
        ],
        \Orchid\Foundation\Events\Systems\RolesEvent::class => [
            \Orchid\Foundation\Listeners\Systems\Roles\RoleBaseListener::class,
        ],
        \Orchid\Foundation\Events\Systems\UserEvent::class => [
            \Orchid\Foundation\Listeners\Systems\Users\UserBaseListener::class,
            \Orchid\Foundation\Listeners\Systems\Users\UserAccessListener::class,
        ],
        \Orchid\Foundation\Events\Marketing\AdvertisingEvent::class => [
            \Orchid\Foundation\Listeners\Marketing\Advertising\AdvertisingBaseListener::class,
            \Orchid\Foundation\Listeners\Marketing\Advertising\AdvertisingCodeListener::class
        ],
        \Orchid\Foundation\Events\Tools\CategoryEvent::class => [
            \Orchid\Foundation\Listeners\Tools\Category\CategoryBaseLister::class,
            \Orchid\Foundation\Listeners\Tools\Category\CategoryDescLister::class
        ],
        \Orchid\Foundation\Events\Marketing\CommentEvent::class => [
            \Orchid\Foundation\Listeners\Marketing\Comment\CommentBaseListener::class,
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
