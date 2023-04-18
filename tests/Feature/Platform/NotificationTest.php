<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Platform\Http\Screens\NotificationScreen;
use Orchid\Platform\Models\User;
use Orchid\Platform\Notifications\DashboardMessage;
use Orchid\Tests\App\Notifications\TaskCompleted;
use Orchid\Tests\TestFeatureCase;

class NotificationTest extends TestFeatureCase
{
    public function testViewNotification(): void
    {
        $response = $this
            ->actingAs($this->createNotifyUser())
            ->get(route('platform.notifications'));

        $response
            ->assertOk()
            ->assertSee('Task Completed');
    }

    public function testMaskAllAsRead(): void
    {
        $user = $this->createNotifyUser();

        $this
            ->actingAs($user)
            ->followingRedirects()
            ->from(route('platform.notifications'))
            ->post(route('platform.action', [
                'screen'       => NotificationScreen::routeName(),
                'method'       => 'markAllAsRead',
            ]))
            ->assertSee('All messages have been read.')
            ->assertDontSee('Mask all as read');

        $user->refresh();
        $this->assertTrue($user->unreadNotifications->isEmpty());
    }

    public function testRemove(): void
    {
        $user = $this->createNotifyUser();

        $this
            ->actingAs($user)
            ->followingRedirects()
            ->from(route('platform.notifications'))
            ->post(route('platform.action', [
                'screen'       => NotificationScreen::routeName(),
                'method'       => 'removeAll',
            ]))
            ->assertSee('All messages have been deleted.')
            ->assertDontSee('Test remove notification')
            ->assertDontSee('Task Completed');

        $this->assertFalse($user->notifications()->exists());
    }

    public function testMaskReadNotification(): void
    {
        $user = $this->createNotifyUser();
        $notification = $user
            ->notifications()
            ->where('type', DashboardMessage::class)
            ->first();

        $this->assertTrue($notification->unread());

        $this
            ->actingAs($user)
            ->from(route('platform.notifications'))
            ->post(route('platform.action', [
                'screen'       => NotificationScreen::routeName(),
                'method'       => 'maskNotification',
                'notification' => $notification->id,
            ]))
            ->assertRedirect();

        $notification = $notification->fresh();
        $this->assertTrue($notification->read());
    }

    public function testShowAPIUnread(): void
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
        $user->notify(new TaskCompleted());

        return $user;
    }
}
