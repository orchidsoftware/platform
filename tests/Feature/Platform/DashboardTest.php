<?php

declare(strict_types=1);

namespace Tests\Feature;

use Orchid\Platform\Models\User;
use Orchid\Tests\TestFeatureCase;

class DashboardTest extends TestFeatureCase
{
    /**
     * debug: php vendor/bin/phpunit  --filter= DashboardTest tests\\Feature\\Platform\\DashboardTest --debug.
     * @var
     */
    private $user;

    public function test_route_DashboardIndex()
    {
        $response = $this->actingAs($this->getUser())
            ->get(route('platform.index'));

        $response->assertStatus(200);
        $this->assertContains('Dashboard Panel', $response->baseResponse->content());
    }

    private function getUser()
    {
        if ($this->user) {
            return $this->user;
        }
        $this->user = factory(User::class)->create();

        return $this->user;
    }

    public function test_route_DashboardIndex_not_user()
    {
        $response = $this->get(route('platform.index'));

        $response->assertStatus(302);
        $response->assertRedirect('/dashboard/login');
        //$this->assertContains('dashboard/login', $response->baseResponse->content());
    }
}
