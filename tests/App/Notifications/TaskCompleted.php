<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Orchid\Platform\Notifications\DashboardChannel;
use Orchid\Platform\Notifications\DashboardMessage;
use Orchid\Support\Color;

class TaskCompleted extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable): array
    {
        return [DashboardChannel::class];
    }

    public function toDashboard($notifiable): DashboardMessage
    {
        return (new DashboardMessage())
            ->title('Task Completed')
            ->message('You have completed work. Well done!')
            ->type(Color::INFO())
            ->action(url('/'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
