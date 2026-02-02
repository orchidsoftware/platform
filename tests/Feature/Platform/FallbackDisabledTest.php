<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Support\Str;
use Orchid\Support\Facades\Orchid;
use Orchid\Tests\TestFeatureCase;

class FallbackDisabledTest extends TestFeatureCase
{
    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        config()->set('orchid.fallback', false);
    }

    public function testRouteDisabled(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(Orchid::prefix('/error-test/').Str::random());

        $response
            ->assertDontSee('orchid.software')
            ->assertDontSee("You requested a page that doesn't exist.");
    }
}
