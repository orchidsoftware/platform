<?php

declare(strict_types=1);

namespace Orchid\Platform\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Orchid\Support\Color;

class DashboardNotification extends Notification
{
    use Queueable;

    /**
     * @var array
     */
    public $message = [];

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
        $message['time'] = Carbon::now();

        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return string[]
     */
    public function via()
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->message;
    }
}
