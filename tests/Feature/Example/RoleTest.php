<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Example;

use Illuminate\Support\Str;
use Orchid\Platform\Models\Role;
use Orchid\Tests\TestFeatureCase;

class RoleTest extends TestFeatureCase
{
    /**
     * @var Role
     */
    private $role;

    protected function setUp(): void
    {
        parent::setUp();
        $this->role = Role::factory()->create();
    }

    public function test_route_systems_roles(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.systems.roles'));

        $response
            ->assertOk()
            ->assertSee($this->role->name)
            ->assertSee($this->role->slug);
    }

    public function test_route_systems_roles_create(): void
    {
        $response = $this->actingAs($this->createAdminUser())
            ->get(route('platform.systems.roles.create'));

        $response
            ->assertOk()
            ->assertSee('field-roles');
    }

    public function test_route_systems_roles_edit(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.systems.roles.edit', $this->role->id));

        $response->assertOk()
            ->assertSee('field-roles')
            ->assertSee($this->role->name)
            ->assertSee($this->role->slug);
    }

    public function test_can_have_string_primary(): void
    {
        $StringPrimaryClass = new class extends Role
        {
            protected $keyType = 'string';
        };

        $role = $StringPrimaryClass::make([
            'id'          => Str::uuid()->toString(),
            'slug'        => 'uuid-test',
            'name'        => 'UUID',
            'permissions' => [],
        ]);

        $this->assertIsString($role->getRoleId());
    }
}
