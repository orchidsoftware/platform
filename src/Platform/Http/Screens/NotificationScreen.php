<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Screens;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
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
    private $isNotEmpty = false;

    /**
     * Query data.
     *
     * @param Request $request
     *
     * @return array
     */
    public function query(Request $request): iterable
    {
        /** @var Paginator $notifications */
        $notifications = $request->user()
            ->notifications()
            ->where('type', DashboardMessage::class)
            ->paginate(10);

        $this->isNotEmpty = $notifications->isNotEmpty();

        return [
            'notifications' => $notifications,
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
            Button::make(__('Remove all'))
                ->icon('trash')
                ->method('removeAll')
                ->canSee($this->isNotEmpty),

            Button::make(__('Mark all as read'))
                ->icon('eye')
                ->method('markAllAsRead')
                ->canSee($this->isNotEmpty),
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
     * @param string  $id
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function maskNotification(string $id, Request $request)
    {
        $notification = $request->user()
            ->notifications()
            ->where('type', DashboardMessage::class)
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        $url = $notification->data['action'] ?? url()->previous();

        return redirect($url);
    }

    /**
     * @param Request $request
     */
    public function markAllAsRead(Request $request)
    {
        $request->user()
            ->unreadNotifications
            ->where('type', DashboardMessage::class)
            ->markAsRead();

        Toast::info(__('All messages have been read.'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeAll(Request $request)
    {
        $request->user()
            ->notifications()
            ->where('type', DashboardMessage::class)
            ->delete();

        Toast::info(__('All messages have been deleted.'));

        return back();
    }

    /**
     * @param Request $request
     *
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
