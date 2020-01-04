<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Models\User;
use Orchid\Tests\TestUnitCase;

/**
 * Class PermissionTest.
 */
class PermissionTest extends TestUnitCase
{
    /**
     * Verify permissions.
     */
    public function testIsPermission()
    {
        $user = $this->createUser();

        // User permissions
        $this->assertTrue($user->hasAccess('access.to.public.data'));
        $this->assertFalse($user->hasAccess('access.to.secret.data'));
        $this->assertFalse($user->hasAccess('access.roles.to.public.data'));

        $role = $this->createRole();
        $user->addRole($role);

        // User of role
        $this->assertEquals($user->getRoles()->count(), 1);
        $this->assertEquals($role->getUsers()->count(), 1);
        $this->assertTrue($user->inRole('admin'));
        $this->assertTrue($user->inRole($role));
        $this->assertFalse($user->inRole('notFoundRole'));

        // Role permissions
        $this->assertTrue($user->hasAccess('access.roles.to.public.data', false));
    }

    /**
     * @return User
     */
    private function createUser(): User
    {
        return User::firstOrCreate([
            'email' => 'test@test.com',
        ], [
            'name'        => 'test',
            'email'       => 'test@test.com',
            'password'    => 'password',
            'permissions' => [
                'access.to.public.data' => 1,
                'access.to.secret.data' => 0,
            ],
        ]);
    }

    /**
     * @return Role
     */
    private function createRole(): Role
    {
        return Role::firstOrCreate([
            'slug' => 'admin',
        ], [
            'slug'        => 'admin',
            'name'        => 'admin',
            'permissions' => [
                'access.roles.to.public.data' => 1,
                'access.roles.to.secret.data' => 0,
            ],
        ]);
    }

    /**
     * Dashboard registered permission.
     */
    public function testIsRegisteredPermission()
    {
        $dashboard = new Dashboard();

        $permission = ItemPermission::group('Test')
            ->addPermission('test', 'Test Description');

        $dashboard->registerPermissions($permission);

        $this->assertEquals($dashboard->getPermission()->count(), 1);
    }

    public function testReplasePermission()
    {
        $user = $this->createUser();

        $user->replaceRoles([]);

        $this->assertTrue($user->roles()->get()->isEmpty());
    }

    /**
     * @throws \Exception
     */
    public function testDeleteUser()
    {
        $user = $this->createUser();
        $role = $this->createRole();

        $user->addRole($role);
        $user->removeRole($role);

        $this->assertFalse($user->inRole($role));

        $user->addRole($role);
        $user->removeRoleBySlug($role->slug);

        $this->assertFalse($user->inRole($role));

        $this->assertTrue($user->delete());
    }

    public function testDeleteRole()
    {
        $user = $this->createUser();
        $role = $this->createRole();

        $user->addRole($role);
        $this->assertTrue($user->inRole($role));

        $this->assertTrue($role->delete());

        $user->refresh();

        $this->assertFalse($user->inRole($role));
    }
}
