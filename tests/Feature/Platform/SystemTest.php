<?php

declare(strict_types=1);

namespace Tests\Feature;

use Orchid\Platform\Models\User;
use Orchid\Tests\TestFeatureCase;

class SystemTest extends TestFeatureCase
{
    /**
     * @var
     */
    private $user;

    private function getUser()
    {
        if ($this->user) {
            return $this->user;
        }
        $this->user = User::where('id',1)->first();
        //$this->user = factory(User::class)->create();

        return $this->user;
    }

    public function testSystemPage()
    {
        $response = $this->actingAs($this->getUser())
                    ->get(route('platform.systems.index'));
                    //->get('dashboard/systems');
                    //->call('GET', 'dashboard/systems');
        $response->assertStatus(200);
        $this->assertContains('Settings', $response->baseResponse->content());
    }
}
