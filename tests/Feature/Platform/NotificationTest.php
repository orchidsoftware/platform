<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Platform\Models\User;
use Orchid\Platform\Notifications\OrchidMessage;
use Orchid\Support\Color;
use Orchid\Tests\App\Notifications\TaskCompleted;
use Orchid\Tests\TestFeatureCase;

class NotificationTest extends TestFeatureCase
{
    public function testNotificationForInnerClass(): void
    {
        $user = $this->createAdminUser();
        $user->notify(OrchidMessage::make()
            ->title('Simple Notification')
            ->action('#')
            ->message('Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
            ->type(Color::INFO)
        );

        $response = $this
            ->actingAs($user)
            ->post(route('orchid.notifications.index'));

        $response
            ->assertOk()
            ->assertSee('Simple Notification')
            ->assertSee('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
    }

    public function testNotificationForNotificationClass(): void
    {
        $response = $this
            ->actingAs($this->createNotifyUser())
            ->post(route('orchid.notifications.index'));

        $response
            ->assertOk()
            ->assertSee('Task Completed');
    }

    public function testMarkAllNotificationsAsRead(): void
    {
        $user = $this->createNotifyUser();

        $this
            ->actingAs($user)
            ->post(route('orchid.notifications.markAllAsRead'))
            ->assertRedirect();

        $user->refresh();
        $this->assertTrue($user->unreadNotifications->isEmpty());
    }

    public function testMarkSingleNotificationAsRead(): void
    {
        $user = $this->createNotifyUser();
        $notification = $user
            ->notifications()
            ->where('type', OrchidMessage::class)
            ->first();

        $this->assertTrue($notification->unread());

        $this
            ->actingAs($user)
            ->post(route('orchid.notifications.markAsRead', $notification->id))
            ->assertRedirect();

        $notification = $notification->fresh();
        $this->assertTrue($notification->read());
    }

    public function testUnreadCount(): void
    {
        $user = $this->createNotifyUser();

        $response = $this
            ->actingAs($user)
            ->post(route('orchid.notifications.unreadCount'));

        $response
            ->assertOk()
            ->assertJson(['total' => 1]);
    }

    private function createNotifyUser(): User
    {
        $user = $this->createAdminUser();
        $user->notify(new TaskCompleted);

        return $user;
    }
}
