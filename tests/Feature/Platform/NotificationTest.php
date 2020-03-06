<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Platform\Models\User;
use Orchid\Platform\Notifications\DashboardMessage;
use Orchid\Tests\Exemplar\App\Notifications\TaskCompleted;
use Orchid\Tests\TestFeatureCase;

class NotificationTest extends TestFeatureCase
{
    public function testViewNotification()
    {
        $response = $this
            ->actingAs($this->createNotifyUser())
            ->get(route('platform.notifications'));

        $response
            ->assertOk()
            ->assertSee('Task Completed');
    }

    public function testMaskAllAsRead()
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

    public function testRemove()
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

    public function testMaskReadNotification()
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

    public function testShowAPIUnread()
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

    /**
     * @return User
     */
    private function createNotifyUser(): User
    {
        $user = $this->createAdminUser();
        $user->notify(new TaskCompleted());

        return $user;
    }
}
