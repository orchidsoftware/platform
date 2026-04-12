<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Screens;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Arr;
use Orchid\Platform\Http\Layouts\NotificationTable;
use Orchid\Platform\Notifications\DashboardMessage;
use Orchid\Platform\Notifications\OrchidMessage;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class NotificationScreen extends Screen
{
    /**
     * Query data.
     */
    public function query(Request $request): array
    {
        $notifications = $request->user()
            ->notifications()
            ->whereIn('type', [OrchidMessage::class, DashboardMessage::class])
            ->paginate();

        return [
            'notifications' => $notifications,
        ];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        return __('Notifications');
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return __('Important events you follow');
    }

    /**
     * Button commands.
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Mark All As Read'))
                ->method('markAllAsRead'),

            Button::make(__('Remove All'))
                ->confirm(__('After deleting notifications, this action cannot be undone and all associated data will be permanently lost.'))
                ->method('removeAll'),
        ];
    }

    /**
     * Views.
     */
    public function layout(): iterable
    {
        return [
            NotificationTable::class,
        ];
    }

    /**
     * Mark all notifications as read.
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
     * Delete all notifications.
     */
    public function removeAll(Request $request): RedirectResponse
    {
        $request->user()
            ->notifications()
            ->whereIn('type', [OrchidMessage::class, DashboardMessage::class])
            ->delete();

        Toast::info(__('All messages have been deleted.'));

        return back();
    }
    /**
     * Mark a single notification as read.
     */
    public function maskNotification(string $id, Request $request): RedirectResponse
    {
        /** @var DatabaseNotification $notification */
        $notification = $request->user()
            ->notifications()
            ->whereIn('type', [OrchidMessage::class, DashboardMessage::class])
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        return back();
    }

    /**
     * Override handle to support routes with {id?}/{method?} parameters.
     *
     * When a POST is made to /notifications/{method} (e.g. /notifications/markAllAsRead),
     * the method name fills the {id?} parameter and {method?} is null.
     * This override detects that situation and sets {method} correctly before
     * delegating to the parent handler.
     */
    public function handle(Request $request, ...$arguments)
    {
        if (! $request->isMethodSafe()) {
            $params = array_filter(
                $request->route()->parameters(),
                fn ($v) => $v !== null
            );

            $lastParam = Arr::last($params);

            if ($lastParam !== null && static::getAvailableMethods()->contains($lastParam)) {
                $request->route()->setParameter('method', $lastParam);
            }
        }

        return parent::handle($request, ...$arguments);
    }
}
