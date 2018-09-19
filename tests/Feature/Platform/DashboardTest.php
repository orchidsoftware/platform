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
        $this
            ->actingAs($this->getUser())
            ->get(route('platform.index'))
            ->assertStatus(302);
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
