<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Orchid\Platform\Notifications\DashboardMessage;

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
            ->unreadNotifications()
            ->where('type', DashboardMessage::class)
            ->limit(15)
            ->get();

        $view->with('notifications', $notifications);
    }
}
