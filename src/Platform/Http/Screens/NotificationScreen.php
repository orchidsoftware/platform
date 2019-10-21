<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Screens;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Orchid\Platform\Http\Layouts\NotificationTable;
use Orchid\Platform\Notifications\DashboardNotification;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

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
    public function query(Request $request): array
    {
        /** @var Paginator $notifications */
        $notifications = $request->user()
            ->notifications()
            ->where('type', DashboardNotification::class)
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
    public function commandBar(): array
    {
        return [
            Button::make(__('Remove all'))
                ->icon('icon-trash')
                ->method('removeAll')
                ->canSee($this->isNotEmpty),

            Button::make(__('Mark all as read'))
                ->icon('icon-eye')
                ->method('markAllAsRead')
                ->canSee($this->isNotEmpty),
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
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
            ->where('type', DashboardNotification::class)
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        $url = $notification->data['action'] ?? url()->previous();

        return redirect($url);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAllAsRead(Request $request)
    {
        $request->user()
            ->unreadNotifications
            ->where('type', DashboardNotification::class)
            ->markAsRead();

        Alert::info(__('All messages have been read.'));

        return back();
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
            ->where('type', DashboardNotification::class)
            ->delete();

        Alert::info(__('All messages have been deleted.'));

        return back();
    }
}
