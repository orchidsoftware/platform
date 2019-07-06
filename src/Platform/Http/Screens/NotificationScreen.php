<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Screens;

use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Alert;
use Orchid\Platform\Http\Layouts\NotificationTable;
use Orchid\Platform\Notifications\DashboardNotification;

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
     * Query data.
     *
     * @return array
     */
    public function query(Request $request): array
    {
        return [
            'notifications' => $request->user()
                ->notifications()
                ->where('type', DashboardNotification::class)
                ->paginate(10),
        ];
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [
            Link::name('Remove all')
                ->icon('icon-trash')
                ->method('removeAll'),

            Link::name('Mark all as read')
                ->icon('icon-eye')
                ->method('markAllAsRead'),
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
            NotificationTable::class,
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

        if (!empty($notification->data['action'])) {
            return redirect($notification->data['action']);
        } else {
            return back();
        }
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

        Alert::warning('Success');

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

        Alert::warning('Success');

        return back();
    }
}
