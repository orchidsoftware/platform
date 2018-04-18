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
     * @var
     */
    public $message;

    /**
     * Status.
     *
     * @var array
     */
    public $type = [
        'info'    => 'text-info',
        'success' => 'text-success',
        'error'   => 'text-danger',
        'warning' => 'text-warning',
    ];

    /**
     * DashboardNotification constructor.
     *
     * @param array $message
     */
    public function __construct(array $message)
    {
        $message['time'] = Carbon::now();

        if (! array_key_exists('type', $message)) {
            $message['type'] = 'info';
        }

        $message['type'] = $this->type[$message['type']];

        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return string[]
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->message;
    }
}
