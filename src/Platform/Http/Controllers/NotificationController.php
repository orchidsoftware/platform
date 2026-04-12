<?php

namespace Orchid\Platform\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\View;
use Orchid\Platform\Notifications\DashboardMessage;
use Orchid\Platform\Notifications\OrchidMessage;
use Orchid\Support\Facades\Toast;

/**
 * Handles user notifications.
 */
class NotificationController extends Controller
{
    /**
     * Display latest user notifications.
     *
     * @param Request $request
     *
     * @return View
     */
    public function index(Request $request)
    {
        /** @var Collection|DatabaseNotification[] $notifications */
        $notifications = $request->user()
            ->notifications()
            ->whereIn('type', [OrchidMessage::class, DashboardMessage::class])
            ->cursorPaginate();

        return view('orchid::partials.notification.notification', [
            'notifications' => $notifications,
        ]);
    }

    /**
     * Mark a notification as read and redirect.
     *
     * @param string  $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function markAsRead(string $id, Request $request)
    {
        /** @var DatabaseNotification $notification */
        $notification = $request->user()
            ->notifications()
            ->whereIn('type', [OrchidMessage::class, DashboardMessage::class])
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        $redirectUrl = $notification->data['action'] ?? url()->previous();

        return redirect($redirectUrl);
    }

    /**
     * Mark all user notifications as read.
     */
    public function markAllAsRead(Request $request): RedirectResponse
    {
        $request->user()
            ->unreadNotifications
            ->whereIn('type', [OrchidMessage::class, DashboardMessage::class])
            ->markAsRead();

        Toast::info(__('All messages have been read.'));

        return back();
    }

    /**
     * Get the count of unread user notifications for dashboard and Orchid messages.
     *
     * @param Request $request
     *
     * @return array
     */
    public function unreadCount(Request $request): array
    {
        $total = $request->user()
            ->unreadNotifications
            ->whereIn('type', [OrchidMessage::class, DashboardMessage::class])
            ->count();

        return [
            'total' => $total,
        ];
    }
}
