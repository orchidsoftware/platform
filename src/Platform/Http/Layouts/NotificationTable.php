<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Layouts;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;

class NotificationTable extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    public $target = 'notifications';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::set('Message', __('Message'))
                ->render(static function ($notification) {
                    return view('platform::partials.notification', [
                        'notification' => $notification,
                    ]);
                }),

            TD::set('', __('Date of creation'))
                ->width('150px')
                ->align(TD::ALIGN_RIGHT)
                ->render(static function ($notification) {
                    return $notification->created_at->diffForHumans();
                }),
        ];
    }

    /**
     * @return string
     */
    public function textNotFound(): string
    {
        return __('No notifications');
    }

    /**
     * @return string
     */
    public function iconNotFound(): string
    {
        return 'icon-bell';
    }

    /**
     * @return string
     */
    public function subNotFound(): string
    {
        return __('You currently have no notifications, but maybe they will appear later.');
    }
}
