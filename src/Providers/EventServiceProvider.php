<?php

namespace Orchid\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Orchid\Core\Models\Newsletter;
use Orchid\Core\Observers\NewsletterObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \Orchid\Events\Systems\SettingsEvent::class      => [
            \Orchid\Listeners\Systems\Settings\SettingInfoListener::class,
            \Orchid\Listeners\Systems\Settings\SettingBaseListener::class,
            \Orchid\Listeners\Systems\Settings\SettingPhpInfoListener::class,
        ],
        \Orchid\Events\Systems\RolesEvent::class         => [
            \Orchid\Listeners\Systems\Roles\RoleBaseListener::class,
        ],
        \Orchid\Events\Systems\UserEvent::class          => [
            \Orchid\Listeners\Systems\Users\UserBaseListener::class,
            \Orchid\Listeners\Systems\Users\UserAccessListener::class,
        ],
        \Orchid\Events\Marketing\AdvertisingEvent::class => [
            \Orchid\Listeners\Marketing\Advertising\AdvertisingBaseListener::class,
            \Orchid\Listeners\Marketing\Advertising\AdvertisingCodeListener::class,
        ],
        \Orchid\Events\Tools\CategoryEvent::class        => [
            \Orchid\Listeners\Tools\Category\CategoryBaseLister::class,
            \Orchid\Listeners\Tools\Category\CategoryDescLister::class,
        ],
        \Orchid\Events\Marketing\CommentEvent::class     => [
            \Orchid\Listeners\Marketing\Comment\CommentBaseListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();

        Newsletter::observe(NewsletterObserver::class);
    }
}
