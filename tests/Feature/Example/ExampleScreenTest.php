<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Example;

use Orchid\Tests\TestFeatureCase;

class ExampleScreenTest extends TestFeatureCase
{
    public function testRoutePlatformExample()
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.example'));

        $response->assertOk()
            ->assertSee('Example Screen')
            ->assertSee('Sample Screen Components');
    }

    public function testRoutePlatformExampleFields()
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.example.fields'));

        $response->assertOk()
            ->assertSee('Example Fields Screen');
    }

    public function testRoutePlatformExampleLayouts()
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.example.layouts'));

        $response->assertOk()
            ->assertSee('Example Layouts Screen');
    }
}
