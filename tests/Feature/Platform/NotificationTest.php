<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Tests\Exemplar\App\Notifications\TaskCompleted;
use Orchid\Tests\TestFeatureCase;

class NotificationTest extends TestFeatureCase
{
   public function testViewNotification()
   {
       $user = $this->createAdminUser();
       $user->notify(new TaskCompleted());

       $response = $this
           ->actingAs($user)
           ->get(route('platform.notifications'));

       $response
           ->assertOk()
           ->assertSee('Task Completed');
   }


   public function testMaskAllAsRead()
   {
       $user = $this->createAdminUser();
       $user->notify(new TaskCompleted());

       $response = $this
           ->actingAs($user)
           ->post(route('platform.notifications',[
               'method' => 'read'
           ]));

       $response->assertDontSee('Mask all as read');
   }

   public function testRemove()
   {
       $user = $this->createAdminUser();
       $user->notify(new TaskCompleted());

       $response = $this
           ->actingAs($user)
           ->post(route('platform.notifications', [
               'method' => 'remove',
           ]));

       $response->assertDontSee('Test remove notification');
       $response->assertDontSee('Task Completed');
   }

}
