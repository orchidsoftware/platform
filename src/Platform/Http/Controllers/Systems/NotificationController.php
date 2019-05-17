<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Systems;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Orchid\Platform\Http\Controllers\Controller;
use Orchid\Platform\Notifications\DashboardNotification;

class NotificationController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications
            ->where('type', DashboardNotification::class)
            ->markAsRead();

        return redirect()->back();
    }

    /**
     * @return RedirectResponse
     */
    public function remove()
    {
        Auth::user()->notifications()
            ->where('type', DashboardNotification::class)
            ->delete();

        return redirect()->back();
    }
}
