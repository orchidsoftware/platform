<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Notifications\DashboardNotification;

class NotificationsComposer
{
    /**
     * Registering the main menu items.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $notifications = Auth::user()
            ->unreadNotifications
            ->where('type', DashboardNotification::class);

        $view->with('notifications', $notifications);
    }
}
