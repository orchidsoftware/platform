<?php

declare(strict_types=1);

namespace Orchid\Platform\Notifications;

use Illuminate\Notifications\Notification;

/**
 * @deprecated Use OrchidChannel instead. Kept for backward compatibility.
 */
class DashboardChannel extends OrchidChannel
{
    /**
     * Build an array payload for the DatabaseNotification model.
     * Stores the type as DashboardMessage::class for backward compatibility.
     */
    protected function buildPayload($notifiable, Notification $notification): array
    {
        return array_merge(parent::buildPayload($notifiable, $notification), [
            'type' => DashboardMessage::class,
        ]);
    }
}
