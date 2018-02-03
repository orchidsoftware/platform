<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Auth\Events\Login;
use Orchid\Platform\Events\CommentEvent;
use Orchid\Platform\Events\CategoryEvent;
use Orchid\Platform\Events\SettingsEvent;
use Orchid\Platform\Events\Systems\UserEvent;
use Orchid\Platform\Events\Systems\RolesEvent;
use Orchid\Platform\Listeners\Category\CategoryBaseLister;
use Orchid\Platform\Listeners\Category\CategoryDescLister;
use Orchid\Platform\Listeners\Comment\CommentBaseListener;
use Orchid\Platform\Listeners\Settings\SettingBaseListener;
use Orchid\Platform\Listeners\Settings\SettingInfoListener;
use Orchid\Platform\Listeners\Systems\Roles\RoleBaseListener;
use Orchid\Platform\Listeners\Systems\Users\UserBaseListener;
use Orchid\Platform\Listeners\Systems\Users\LogSuccessfulLogin;
use Orchid\Platform\Listeners\Systems\Users\UserAccessListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RolesEvent::class    => [
            RoleBaseListener::class,
        ],
        UserEvent::class     => [
            UserBaseListener::class,
            UserAccessListener::class,
        ],
        Login::class         => [
            LogSuccessfulLogin::class,
        ],
        SettingsEvent::class => [
            SettingInfoListener::class,
            SettingBaseListener::class,
        ],
        CategoryEvent::class => [
            CategoryBaseLister::class,
            CategoryDescLister::class,
        ],
        CommentEvent::class  => [
            CommentBaseListener::class,
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
