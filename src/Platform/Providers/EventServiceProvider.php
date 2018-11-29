<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Auth\Events\Login;
use Orchid\Platform\Models\Announcement;
use Orchid\Platform\Listeners\LogSuccessfulLogin;
use Orchid\Platform\Observers\AnnouncementObserver;
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
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();

        Announcement::observe(AnnouncementObserver::class);
    }
}
