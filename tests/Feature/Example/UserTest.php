<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Example;

use Orchid\Tests\TestFeatureCase;

class UserTest extends TestFeatureCase
{
    public function test_route_systems_users(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.systems.users'));

        $response->assertOk()
            ->assertSee($this->createAdminUser()->name)
            ->assertSee($this->createAdminUser()->email);
    }

    public function test_route_systems_users_create(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('orchid.systems.users.create'));

        $response->assertOk()
            ->assertSee('field-user');
    }

    public function test_route_systems_users_edit(): void
    {
        $user = $this->createAdminUser();

        $this
            ->actingAs($user)
            ->get(route('platform.systems.users.edit', $user->id))
            ->assertSee($user->name)
            ->assertSee($user->email);
    }

    public function test_route_systems_users_edit_remove(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.systems.users.edit', [$this->createAdminUser()->id, 'remove']));

        $response
            ->assertStatus(302)
            ->assertRedirect('/dashboard/users');
    }
}
