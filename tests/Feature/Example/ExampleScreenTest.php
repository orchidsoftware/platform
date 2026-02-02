<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Example;

use Orchid\Tests\TestFeatureCase;

class ExampleScreenTest extends TestFeatureCase
{
    public function testRoutePlatformExample(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('orchid.example'));

        $response->assertOk()
            ->assertSee('Example Screen')
            ->assertSee('Sample Screen Components');
    }

    public function testRoutePlatformExampleFields(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('orchid.example.fields'));

        $response->assertOk()
            ->assertSee('Form Controls');
    }

    public function testRoutePlatformExampleLayouts(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('orchid.example.layouts'));

        $response->assertOk()
            ->assertSee('Layout Overview');
    }
}
