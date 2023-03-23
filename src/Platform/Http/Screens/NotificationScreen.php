<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Screens;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Orchid\Platform\Http\Layouts\NotificationTable;
use Orchid\Platform\Notifications\DashboardMessage;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class NotificationScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Notifications';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Important events you follow';

    /**
     * @var string
     */
    public $permission = 'platform.index';

    /**
     * @var bool
     */
    public $isNotEmpty = false;

    /**
     * @var bool
     */
    public $hasUnread = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Request $request): iterable
    {
        $user = $request->user();

        return [
            'isNotEmpty'    => $this->prepareUserNotificationRelation($user)->exists(),
            'hasUnread'     => $this->prepareUserNotificationRelation($user)->unread()->exists(),
            'notifications' => $this->prepareUserNotificationRelation($user)->paginate(10),
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Remove All'))
                ->icon('bs.trash')
                ->method('removeAll')
                ->confirm(__('After deleting notifications, this action cannot be undone and all associated data will be permanently lost.'))
                ->disabled(! $this->isNotEmpty),

            Button::make(__('Mark All As Read'))
                ->icon('bs.eye')
                ->method('markAllAsRead')
                ->disabled(! $this->hasUnread),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::wrapper('platform::partials.notification-wrap', [
                'table' => NotificationTable::class,
            ]),
        ];
    }

    /**
     * @param mixed $user
     *
     * @return mixed
     */
    private function prepareUserNotificationRelation(mixed $user)
    {
        return $user->notifications()->where('type', DashboardMessage::class);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function maskNotification(string $id, Request $request)
    {
        $notification = $this->prepareUserNotificationRelation($request->user())
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        $url = $notification->data['action'] ?? url()->previous();

        return redirect($url);
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()
            ->unreadNotifications
            ->where('type', DashboardMessage::class)
            ->markAsRead();

        Toast::info(__('All messages have been read.'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeAll(Request $request)
    {
        $this->prepareUserNotificationRelation($request->user())->delete();

        Toast::info(__('All messages have been deleted.'));

        return back();
    }

    /**
     * @return LengthAwarePaginator
     */
    public function unreadNotification(Request $request)
    {
        return $request->user()
            ->unreadNotifications()
            ->where('type', DashboardMessage::class)
            ->paginate();
    }
}
