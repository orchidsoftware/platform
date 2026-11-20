<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\DB;
use Orchid\Platform\Components\Notification;
use Orchid\Platform\Models\User;
use Orchid\Platform\Notifications\DashboardMessage;
use Orchid\Platform\Notifications\OrchidMessage;
use Orchid\Support\Color;
use Orchid\Tests\App\Notifications\TaskCompleted;
use Orchid\Tests\Database\Factory\DatabaseNotificationFactory;
use Orchid\Tests\TestFeatureCase;

class NotificationTest extends TestFeatureCase
{
    public function testNotificationModalStartsWithHiddenFooter(): void
    {
        $html = view('orchid::partials.notification.modal')->render();

        $this->assertStringContainsString('id="orchid-notifications-footer" hidden', $html);
    }

    public function testEmptyNotificationsUseEmptyState(): void
    {
        $this
            ->actingAs($this->createAdminUser())
            ->post(route('orchid.notifications.index'))
            ->assertOk()
            ->assertSee('empty-state')
            ->assertSee('No new notifications.')
            ->assertSeeHtml('id="orchid-notifications-footer"')
            ->assertSeeHtml('hidden')
            ->assertDontSee('Mark All As Read');
    }

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

    public function testMarkAllAsReadOnlyUpdatesSupportedUnreadNotificationsForCurrentUser(): void
    {
        $this->freezeSecond();
        $user = $this->createAdminUser();
        $factory = DatabaseNotificationFactory::new()->for($user, 'notifiable');
        $orchid = $factory->createOne();
        $dashboard = $factory->createOne(['type' => DashboardMessage::class]);
        $alreadyRead = $factory->createOne(['read_at' => now()->subDay()]);
        $unrelated = $factory->createOne(['type' => 'OtherNotification']);
        $otherUser = DatabaseNotificationFactory::new()
            ->for(User::factory()->create(), 'notifiable')
            ->createOne();

        $this->actingAs($user)
            ->post(route('orchid.notifications.markAllAsRead'))
            ->assertRedirect();

        $this->assertTrue($orchid->fresh()->read_at->equalTo(now()));
        $this->assertTrue($dashboard->fresh()->read_at->equalTo(now()));
        $this->assertTrue($alreadyRead->fresh()->read_at->equalTo(now()->subDay()));
        $this->assertNull($unrelated->fresh()->read_at);
        $this->assertNull($otherUser->fresh()->read_at);
    }

    public function testMarkAllAsReadUsesOneUpdateWithoutHydratingNotifications(): void
    {
        $user = $this->createAdminUser();
        DatabaseNotificationFactory::new()->count(3)->for($user, 'notifiable')->create();

        DatabaseNotification::retrieved(
            fn () => $this->fail('Marking all notifications as read must not hydrate notification models.')
        );

        DB::enableQueryLog();
        DB::flushQueryLog();

        $this->actingAs($user)
            ->post(route('orchid.notifications.markAllAsRead'))
            ->assertRedirect();

        $updates = collect(DB::getQueryLog())->filter(fn ($query) => str_starts_with($query['query'], 'update')
            && str_contains($query['query'], 'notifications'));

        $this->assertCount(1, $updates);
        $this->assertSame(0, $user->unreadNotifications()->count());
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

        $this->assertFalse(
            $user->relationLoaded('unreadNotifications'),
            'Counting unread notifications must not hydrate the notification relation.',
        );
    }

    public function testNotificationBadgeCapsDoubleDigitCountForFrontendIndicator(): void
    {
        $user = $this->createAdminUser();

        DatabaseNotificationFactory::new()
            ->count(11)
            ->for($user, 'notifiable')
            ->create();

        $this->actingAs($user);

        DatabaseNotification::retrieved(
            fn () => $this->fail('Rendering the notification badge must not hydrate notification models.')
        );

        $view = $this->app->make(Notification::class)->render();

        $this->assertSame(10, $view->getData()['unreadCount']);
    }

    private function createNotifyUser(): User
    {
        $user = $this->createAdminUser();
        $user->notify(new TaskCompleted);

        return $user;
    }
}
