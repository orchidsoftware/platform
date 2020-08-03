<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Tests\TestFeatureCase;

class ResourceTest extends TestFeatureCase
{
    public function testRouteResource(): void
    {
        $response = $this
            ->get(route('platform.resource', ['orchid', 'mix-manifest.json']));

        $response->assertOk();
    }
}
