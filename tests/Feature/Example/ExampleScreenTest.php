<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Example;

use Orchid\Platform\Models\User;
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
}
