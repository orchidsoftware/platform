<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Support\Str;
use Orchid\Platform\Orchid;
use Orchid\Tests\TestFeatureCase;

class FallbackEnabledTest extends TestFeatureCase
{
    public function test_route_enabled(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(Orchid::prefix('/error-test/').Str::random());

        $response
            ->assertSee('orchid.software')
            ->assertSee("You requested a page that doesn't exist.");
    }
}
