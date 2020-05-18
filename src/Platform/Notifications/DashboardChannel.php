<?php

declare(strict_types=1);

namespace Orchid\Platform\Notifications;

use Illuminate\Notifications\Channels\DatabaseChannel;
use Illuminate\Notifications\Notification;

class DashboardChannel extends DatabaseChannel
{
    /**
     * Build an array payload for the DatabaseNotification Model.
     *
     * @param mixed        $notifiable
     * @param Notification $notification
     *
     * @return array
     */
    protected function buildPayload($notifiable, Notification $notification)
    {
        return [
            'id'      => $notification->id,
            'type'    => DashboardMessage::class,
            'data'    => $this->getData($notifiable, $notification),
            'read_at' => null,
        ];
    }

    /**
     * Get the data for the notification.
     *
     * @param mixed        $notifiable
     * @param Notification $notification
     *
     * @throws \RuntimeException
     *
     * @return array
     */
    protected function getData($notifiable, Notification $notification)
    {
        if (method_exists($notification, 'toDashboard')) {
            return is_array($data = $notification->toDashboard($notifiable))
                ? $data : $data->data;
        }

        throw new \RuntimeException('Notification is missing toDashboard method.');
    }
}
