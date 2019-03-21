<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Example;

use Orchid\Tests\TestFeatureCase;

class UserTest extends TestFeatureCase
{
    public function testRouteSystemsUsers()
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.systems.users'));

        $response->assertOk()
            ->assertSee($this->createAdminUser()->name)
            ->assertSee($this->createAdminUser()->email);
    }

    public function testRouteSystemsUsersEdit()
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.systems.users.edit', $this->createAdminUser()->id));

        $response->assertOk()
            ->assertSee($this->createAdminUser()->name)
            ->assertSee($this->createAdminUser()->email);
    }

    public function testRouteSystemsUsersEditRemove()
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.systems.users.edit', [$this->createAdminUser()->id, 'remove']));

        $response
            ->assertStatus(302)
            ->assertRedirect('/dashboard/users');
    }
}
