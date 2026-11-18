<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Orchid\Platform\Notifications\OrchidChannel;
use Orchid\Platform\Notifications\OrchidMessage;
use Orchid\Support\Color;

class TaskCompleted extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @return list<class-string<OrchidChannel>>
     */
    public function via(mixed $notifiable): array
    {
        return [OrchidChannel::class];
    }

    public function toOrchid(mixed $notifiable): OrchidMessage
    {
        return (new OrchidMessage)
            ->title('Task Completed')
            ->message('You have completed work. Well done!')
            ->type(Color::INFO)
            ->action(url('/'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array{}
     */
    public function toArray(mixed $notifiable): array
    {
        return [
            //
        ];
    }
}
