<?php

declare(strict_types=1);

namespace Orchid\Platform\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Orchid\Support\Color;

/**
 * Class DashboardNotification.
 *
 * @deprecated
 */
class DashboardNotification extends Notification
{
    use Queueable;

    /**
     * @var array
     */
    public $message = [
        'title'   => null,
        'action'  => '#',
        'message' => '',
    ];

    /**
     * @deprecated
     */
    public const INFO = 'info';

    /**
     * @deprecated
     */
    public const SUCCESS = 'success';

    /**
     * @deprecated
     */
    public const ERROR = 'danger';

    /**
     * @deprecated
     */
    public const WARNING = 'warning';

    /**
     * DashboardNotification constructor.
     *
     * @param array $message
     */
    public function __construct(array $message)
    {
        $message['type'] = $message['type'] ?? Color::INFO;

        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return string[]
     */
    public function via()
    {
        return [DashboardChannel::class];
    }

    /**
     * Get the dashboard representation of the notification.
     *
     * @return DashboardMessage
     */
    public function toDashboard()
    {
        return (new DashboardMessage)
            ->title($this->message['title'])
            ->message($this->message['message'])
            ->action($this->message['action'])
            ->type($this->message['type']);
    }
}
