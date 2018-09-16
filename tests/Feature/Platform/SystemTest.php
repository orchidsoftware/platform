<?php

declare(strict_types=1);

namespace Tests\Feature;

use Orchid\Platform\Models\User;
use Orchid\Tests\TestFeatureCase;

class SystemTest extends TestFeatureCase
{
    /**
     * debug: php vendor/bin/phpunit  --filter= SystemTest tests\\Feature\\Platform\\SystemTest --debug.
     * @var
     */
    private $user;

    public function setUp()
    {
        parent::setUp();

        //$this->withoutMiddleware();
        if ($this->user) {
            return $this->user;
        }
        $this->user = factory(User::class)->create();
    }

    /*
        private function getUser()
        {
            if ($this->user) {
                return $this->user;
            }
    
            $this->user = User::where('id', 1)->first();
            //$this->user = factory(User::class)->create();
    
            return $this->user;
        }
    */

    public function test_route_PlatformSystemsIndex()
    {
        $response = $this->actingAs($this->user)
            ->get(route('platform.systems.index'));
        //->get('dashboard/systems');
        //->call('GET', 'dashboard/systems');

        $response->assertStatus(200);
        $this->assertContains('Settings', $response->baseResponse->content());
    }

    public function test_route_PlatformSystemsMenuIndex()
    {
        $response = $this->actingAs($this->user)
            ->get(route('platform.systems.menu.index'));
        //dump($response->baseResponse->content());
        $response->assertStatus(302);
        $response->assertRedirect('/dashboard/press/menu/header');
        //$this->assertContains('dashboard/press/menu/header', $response->baseResponse->content());
    }

    public function test_route_PlatformSystemsMenuShow()
    {
        $response = $this->actingAs($this->user)
            ->get(route('platform.systems.menu.show', 'header'));
        $response->assertStatus(200);
        $this->assertContains('data-controller="components--menu"', $response->baseResponse->content());
    }

    public function test_route_PlatformSystemsMediaIndex()
    {
        $response = $this->actingAs($this->user)
            ->get(route('platform.systems.media.index'));
        $response->assertStatus(200);
        $this->assertContains('id="filemanager"', $response->baseResponse->content());
    }
}
