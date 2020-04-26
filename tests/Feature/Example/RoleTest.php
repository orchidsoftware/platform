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
        $this->role = factory(Role::class)->create();
    }

    public function testRouteSystemsRoles()
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.systems.roles'));

        $response
            ->assertOk()
            ->assertSee($this->role->name)
            ->assertSee($this->role->slug);
    }

    public function testRouteSystemsRolesCreate()
    {
        $response = $this->actingAs($this->createAdminUser())
            ->get(route('platform.systems.roles.create'));

        $response
            ->assertOk()
            ->assertSee('field-roles');
    }

    public function testRouteSystemsRolesEdit()
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.systems.roles.edit', $this->role->slug));

        $response->assertOk()
        ->assertSee('field-roles')
        ->assertSee($this->role->name)
        ->assertSee($this->role->slug);
    }

    public function testCanHaveStringPrimary(): void
    {
        $StringPrimaryClass = new class extends Role {
            protected $keyType = 'string';
        };

        $role = $StringPrimaryClass::make([
            'id'          => Str::uuid(),
            'slug'        => 'uuid-test',
            'name'        => 'UUID',
            'permissions' => [],
        ]);

        $this->assertIsString($role->getRoleId());
    }
}
