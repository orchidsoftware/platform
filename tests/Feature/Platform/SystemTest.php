<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Tests\TestFeatureCase;

class SystemTest extends TestFeatureCase
{
    public function testRoutePlatformSystemsIndex(): void
    {
        $response = $this->actingAs($this->createAdminUser())
            ->get(route('platform.systems.index'));

        $response->assertOk();
        $this->assertStringContainsString('System', $response->getContent());
    }
}
