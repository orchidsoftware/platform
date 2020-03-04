<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Tests\TestFeatureCase;

class NotificationTest extends TestFeatureCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('To do');
    }

    /*
   public function testViewNotification()
   {
       $this->createNotification('Hello Test');

       $response = $this
           ->actingAs($this->createAdminUser())
           ->get(route('platform.notifications'));

       $response
           ->assertOk()
           ->assertSee('Hello Test');
   }


   public function testMaskAllAsRead()
   {
       $this->createNotification('Mask all as read');

       $response = $this
           ->actingAs($this->createAdminUser())
           ->post(route('platform.notification.read'));

       $response->assertDontSee('Mask all as read');
   }

   public function testRemove()
   {
       $this->createNotification('Test remove notification');

       $response = $this
           ->actingAs($this->createAdminUser())
           ->post(route('platform.notification.remove'));

       $response->assertDontSee('Test remove notification');
   }


    private function createNotification($title = 'test')
    {
        $this->createAdminUser()->notify(new DashboardNotification([
            'title'   => $title,
            'message' => 'New Test!',
            'action'  => 'https://orchid.software',
            'type'    => DashboardNotification::SUCCESS,
        ]));
    }
     */
}
