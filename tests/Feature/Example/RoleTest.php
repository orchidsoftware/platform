<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Example;

use Orchid\Platform\Models\Role;
use Orchid\Platform\Models\User;
use Orchid\Tests\TestFeatureCase;

class RoleTest extends TestFeatureCase
{
    /**
     * debug: php vendor/bin/phpunit  --filter= RoleTest tests\\Feature\\Example\\RoleTest --debug.
     *
     * @var
     */
    private $user;

    private $role;

    public function setUp() : void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->role = factory(Role::class)->create();
    }

    public function test_route_SystemsRoles()
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('platform.systems.roles'));

        $response
            ->assertOk()
            ->assertSee($this->role->name)
            ->assertSee($this->role->slug);
    }

    public function test_route_SystemsRolesCreate()
    {
        $response = $this->actingAs($this->user)
            ->get(route('platform.systems.roles.create'));

        $response
            ->assertOk()
            ->assertSee('field-roles');
    }

    public function test_route_SystemsRolesEdit()
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('platform.systems.roles.edit', $this->role->slug));

        $response->assertOk()
        ->assertSee('field-roles')
        ->assertSee($this->role->name)
        ->assertSee($this->role->slug);
    }
}
