<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Platform\Models\User;
use Orchid\Tests\TestFeatureCase;

class SystemTest extends TestFeatureCase
{
    /**
     * debug: php vendor/bin/phpunit  --filter= SystemTest tests\\Feature\\Platform\\SystemTest --debug.
     * @var
     */
    private $user;

    public function setUp() : void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function test_route_PlatformSystemsIndex()
    {
        $response = $this->actingAs($this->user)
            ->get(route('platform.systems.index'));

        $response->assertOk();
        $this->assertStringContainsString('System', $response->getContent());
    }

    public function test_route_PlatformSystemsMenuIndex()
    {
        $response = $this->actingAs($this->user)
            ->get(route('platform.systems.menu.index'));

        $response->assertStatus(302);
        $response->assertRedirect('/dashboard/press/menu/header');
    }

    public function test_route_PlatformSystemsMenuShow()
    {
        $response = $this->actingAs($this->user)
            ->get(route('platform.systems.menu.show', 'header'));
        $response->assertOk();
        $this->assertStringContainsString('data-controller="components--menu"', $response->getContent());
    }
}
