<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

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
        $response = $this
            ->actingAs($this->getUser())
            ->get(route('platform.index'));

        $response
            ->assertStatus(302)
            ->assertRedirect('/dashboard/main');
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

        $response
            ->assertStatus(302)
            ->assertRedirect('/dashboard/login');
    }

    public function test_route_SaviorBackups()
    {
        $response = $this
            ->actingAs($this->getUser())
            ->get(route('platform.systems.backups'));

        $response->assertOk();
    }

    public function test_route_SaviorBackups_method_runBackup()
    {
        $response = $this
            ->actingAs($this->getUser())
            ->post(route('platform.systems.backups', 'runBackup'));

        $response->assertStatus(302);
    }
}
