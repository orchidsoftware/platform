<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Auth\Events\Login;
use Spatie\Activitylog\Models\Activity;
use Orchid\Platform\Events\CommentEvent;
use Orchid\Platform\Events\CategoryEvent;
use Orchid\Platform\Events\UploadFileEvent;
use Orchid\Platform\Observers\ActivityLogObserver;
use Orchid\Platform\Listeners\Attachment\UploadFileLister;
use Orchid\Platform\Listeners\Category\CategoryBaseLister;
use Orchid\Platform\Listeners\Category\CategoryDescLister;
use Orchid\Platform\Listeners\Comment\CommentBaseListener;
use Orchid\Platform\Listeners\Systems\Users\LogSuccessfulLogin;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Login::class         => [
            LogSuccessfulLogin::class,
        ],
        CategoryEvent::class => [
            CategoryBaseLister::class,
            CategoryDescLister::class,
        ],
        CommentEvent::class  => [
            CommentBaseListener::class,
        ],
        UploadFileEvent::class => [
                UploadFileLister::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();

        Activity::observe(ActivityLogObserver::class);
    }
}
