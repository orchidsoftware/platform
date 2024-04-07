<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Example;

use Orchid\Tests\TestFeatureCase;

class UserTest extends TestFeatureCase
{
    public function testRouteSystemsUsers(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.systems.users'));

        $response->assertOk()
            ->assertSee($this->createAdminUser()->name)
            ->assertSee($this->createAdminUser()->email);
    }

    public function testRouteSystemsUsersCreate(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('orchid.systems.users.create'));

        $response->assertOk()
            ->assertSee('field-user');
    }

    public function testRouteSystemsUsersEdit(): void
    {
        $user = $this->createAdminUser();

        $this
            ->actingAs($user)
            ->get(route('platform.systems.users.edit', $user->id))
            ->assertSee($user->name)
            ->assertSee($user->email);
    }

    public function testRouteSystemsUsersEditRemove(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.systems.users.edit', [$this->createAdminUser()->id, 'remove']));

        $response
            ->assertStatus(302)
            ->assertRedirect('/dashboard/users');
    }
}
