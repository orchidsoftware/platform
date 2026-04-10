<?php

declare(strict_types=1);

namespace Orchid\Platform\Notifications;

use Illuminate\Notifications\Channels\DatabaseChannel;
use Illuminate\Notifications\Notification;

class OrchidChannel extends DatabaseChannel
{
    /**
     * Build an array payload for the DatabaseNotification model.
     *
     * @param mixed        $notifiable   The notifiable entity instance
     * @param Notification $notification The notification object instance
     *
     * @return array
     */
    protected function buildPayload($notifiable, Notification $notification): array
    {
        return [
            'id'      => $notification->id,
            'type'    => OrchidMessage::class,
            'data'    => $this->getData($notifiable, $notification),
            'read_at' => null,
        ];
    }

    /**
     * Get the data for the notification.
     *
     * @param mixed        $notifiable   The notifiable entity instance
     * @param Notification $notification The notification object instance
     *
     * @throws \RuntimeException
     *
     * @return array
     */
    protected function getData($notifiable, Notification $notification): array
    {
        if (method_exists($notification, 'toOrchid')) {
            return is_array($data = $notification->toOrchid($notifiable))
                ? $data : $data->data;
        }
        if (method_exists($notification, 'toDashboard')) {
            return is_array($data = $notification->toDashboard($notifiable))
                ? $data : $data->data;
        }

        throw new \RuntimeException('Notification is missing toOrchid or toDashboard method.');
    }
}
