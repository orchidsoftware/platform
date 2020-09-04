<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Tests\TestFeatureCase;

class DashboardTest extends TestFeatureCase
{
    public function testRouteDashboardIndex(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.index'));

        $response
            ->assertStatus(302)
            ->assertRedirect('/dashboard/main');
    }

    public function testRouteDashboardIndexNotUser(): void
    {
        $response = $this->get(route('platform.index'));

        $response
            ->assertStatus(302)
            ->assertRedirect('/dashboard/login');
    }
}
