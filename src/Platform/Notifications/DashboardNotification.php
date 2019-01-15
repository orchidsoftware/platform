<?php

declare(strict_types=1);

namespace Orchid\Platform\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DashboardNotification extends Notification
{
    use Queueable;

    /**
     * @var array|null
     */
    public $message;

    /**
     * Status.
     */
    public const INFO = 'text-info';

    /**
     * Status.
     */
    public const SUCCESS = 'text-success';

    /**
     * Status.
     */
    public const ERROR = 'text-danger';

    /**
     * Status.
     */
    public const WARNING = 'text-warning';

    /**
     * DashboardNotification constructor.
     *
     * @param array $message
     */
    public function __construct(array $message)
    {
        $message['type'] = $message['type'] ?? self::INFO;
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
