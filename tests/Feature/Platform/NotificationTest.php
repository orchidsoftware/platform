<?php

declare(strict_types=1);

namespace Tests\Feature\Platform;

use Orchid\Platform\Models\User;
use Orchid\Tests\TestFeatureCase;
use Orchid\Platform\Notifications\DashboardNotification;

class NotificationTest extends TestFeatureCase
{
    /**
     * @var User
     */
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function test_view_notification()
    {
        $this->createNotification('Hello Test');

        $response = $this
            ->actingAs($this->user)
            ->get(route('platform.main'));

        $response->assertStatus(200);
        $this->assertContains('Hello Test', $response->getContent());
    }

    public function test_mask_all_as_read()
    {
        $this->createNotification('Mask all as read');

        $response = $this
            ->actingAs($this->user)
            ->post(route('platform.notification.read'));

        $this->assertNotContains('Mask all as read', $response->getContent());
    }

    public function test_remove()
    {
        $this->createNotification('Test remove notification');

        $response = $this
            ->actingAs($this->user)
            ->post(route('platform.notification.remove'));

        $this->assertNotContains('Test remove notification', $response->getContent());
    }

    /**
     * @param string $title
     */
    private function createNotification($title = 'test')
    {
        $this->user->notify(new DashboardNotification([
            'title'   => $title,
            'message' => 'New Test!',
            'action'  => 'https://orchid.software',
            'type'    => DashboardNotification::SUCCESS,
        ]));
    }
}
