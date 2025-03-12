<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Platform\Models\User;
use Orchid\Platform\Notifications\DashboardMessage;
use Orchid\Support\Color;
use Orchid\Tests\App\Notifications\TaskCompleted;
use Orchid\Tests\TestFeatureCase;

class NotificationTest extends TestFeatureCase
{
    public function testNotificationForInnerClass():void
    {
        $user = $this->createAdminUser();
        $user->notify(DashboardMessage::make()
            ->title('Simple Notification')
            ->action('#')
            ->message('Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
            ->type(Color::INFO)
        );

        $response = $this
            ->actingAs($user)
            ->get(route('platform.notifications'));

        $response
            ->assertOk()
            ->assertSee('Simple Notification')
            ->assertSee('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
    }


    public function testNotificationForNotificationClass(): void
    {
        $response = $this
            ->actingAs($this->createNotifyUser())
            ->get(route('platform.notifications'));

        $response
            ->assertOk()
            ->assertSee('Task Completed');
    }

    public function testMarkAllNotificationsAsRead(): void
    {
        $user = $this->createNotifyUser();

        $this
            ->actingAs($user)
            ->post(route('platform.notifications', 'markAllAsRead'))
            ->assertRedirect();

        $this
            ->actingAs($user)
            ->get(route('platform.notifications'))
            ->assertSee('All messages have been read.')
            ->assertDontSee('Mask all as read');
    }

    public function testDeleteAllNotifications(): void
    {
        $user = $this->createNotifyUser();

        $this
            ->actingAs($user)
            ->post(route('platform.notifications', 'removeAll'))
            ->assertRedirect();

        $this
            ->actingAs($user)
            ->get(route('platform.notifications'))
            ->assertSee('All messages have been deleted.')
            ->assertDontSee('Test remove notification')
            ->assertDontSee('Task Completed');
    }

    public function testMarkSingleNotificationAsRead(): void
    {
        $user = $this->createNotifyUser();
        $notification = $user
            ->notifications()
            ->where('type', DashboardMessage::class)
            ->first();

        $this->assertTrue($notification->unread());

        $this
            ->actingAs($user)
            ->post(route('platform.notifications', [$notification->id, 'maskNotification']))
            ->assertRedirect();

        $notification = $notification->fresh();
        $this->assertTrue($notification->read());
    }

    public function testAPIReturnsUnreadNotifications(): void
    {
        $response = $this
            ->actingAs($this->createNotifyUser())
            ->post(route('platform.api.notifications'));

        $response
            ->assertOk()
            ->assertJsonFragment([
                'type'    => 'info',
                'title'   => 'Task Completed',
                'message' => 'You have completed work. Well done!',
            ]);
    }

    private function createNotifyUser(): User
    {
        $user = $this->createAdminUser();
        $user->notify(new TaskCompleted);

        return $user;
    }
}
