<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Tests\TestFeatureCase;

class DashboardTest extends TestFeatureCase
{
    public function testRouteDashboardIndex()
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.index'));

        $response
            ->assertStatus(302)
            ->assertRedirect('/dashboard/main');
    }

    public function testRouteDashboardIndexNotUser()
    {
        $response = $this->get(route('platform.index'));

        $response
            ->assertStatus(302)
            ->assertRedirect('/dashboard/login');
    }
}
