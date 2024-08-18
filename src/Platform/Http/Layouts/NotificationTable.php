<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Layouts;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

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
            TD::make('Message', __('Messages'))
                ->cantHide()
                ->render(static fn ($notification) => view('platform::partials.notification', [
                    'notification' => $notification,
                ])),
        ];
    }

    public function textNotFound(): string
    {
        return __('No notifications');
    }

    public function iconNotFound(): string
    {
        return 'bs.bell';
    }

    public function subNotFound(): string
    {
        return __('You currently have no notifications, but maybe they will appear later.');
    }
}
