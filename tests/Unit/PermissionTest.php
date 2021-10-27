<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Exception;
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
    public function testIsPermission(): void
    {
        $user = $this->createUser();

        // User permissions
        $this->assertTrue($user->hasAccess('access.to.public.data'));
        $this->assertFalse($user->hasAccess('access.to.secret.data'));
        $this->assertFalse($user->hasAccess('access.roles.to.public.data'));

        $role = $this->createRole();
        $user->addRole($role);

        // User of role
        $this->assertEquals(1, $user->getRoles()->count());
        $this->assertEquals(1, $role->getUsers()->count());
        $this->assertTrue($user->inRole('admin'));
        $this->assertTrue($user->inRole($role));
        $this->assertFalse($user->inRole('notFoundRole'));

        // Role permissions
        $this->assertTrue($user->hasAccess('access.roles.to.public.data', false));

        // duplicate
        $user->clearCachePermission();

        $this->assertTrue($user->hasAccess('access.user.duplicate'));
        $this->assertTrue($user->hasAccess('access.role.duplicate'));
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
                'access.user.duplicate' => 1,
                'access.role.duplicate' => 0,
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
                'access.user.duplicate'       => 0,
                'access.role.duplicate'       => 1,
                'access.roles.to.public.data' => 1,
                'access.roles.to.secret.data' => 0,
            ],
        ]);
    }

    /**
     * Dashboard registered permission.
     */
    public function testIsRegisteredPermission(): void
    {
        $dashboard = new Dashboard();

        $permission = ItemPermission::group('Test')
            ->addPermission('test', 'Test Description');

        $dashboard->registerPermissions($permission);

        $this->assertEquals(1, $dashboard->getPermission()->count());
    }

    /**
     * Dashboard remove permission.
     */
    public function testIsWasRemovedPermission(): void
    {
        $dashboard = new Dashboard();
        $permission = ItemPermission::group('Test')
            ->addPermission('test', 'Test Description');
        $dashboard->registerPermissions($permission);
        $dashboard->removePermission('test');
        $this->assertEmpty($dashboard->getPermission()->get('Test'));
    }

    public function testReplasePermission(): void
    {
        $user = $this->createUser();

        $user->replaceRoles([]);

        $this->assertTrue($user->roles()->get()->isEmpty());
    }

    /**
     * @throws Exception
     */
    public function testDeleteUser(): void
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

    public function testDeleteRole(): void
    {
        $user = $this->createUser();
        $role = $this->createRole();

        $user->addRole($role);
        $this->assertTrue($user->inRole($role));

        $this->assertTrue($role->delete());

        $user->refresh();

        $this->assertFalse($user->inRole($role));
    }

    public function testDeleteUnknownRole(): void
    {
        $user = $this->createUser();

        $roleUser = Role::factory()->create(['slug' => 'User']);
        $roleModerator = Role::factory()->create(['slug' => 'Moderator']);

        $user->addRole($roleUser);
        $user->addRole($roleModerator);

        $this->assertTrue($user->inRole($roleUser));
        $this->assertTrue($user->inRole($roleModerator));

        $user->removeRoleBySlug('Unknown Role Slug');
        $user->refresh();

        $this->assertTrue($user->inRole($roleUser));
        $this->assertTrue($user->inRole($roleModerator));

        $user->removeRoleBySlug('Moderator');
        $user->refresh();

        $this->assertTrue($user->inRole($roleUser));
        $this->assertFalse($user->inRole($roleModerator));
    }

    public function testEmptyPermission(): void
    {
        $nullPermission = $this->createUser()
            ->setAttribute('permissions', null)
            ->hasAccess('access.to.secret.data');

        $stringPermission = $this->createUser()
            ->setAttribute('permissions', '')
            ->hasAccess('access.to.secret.data');

        $this->assertFalse($nullPermission);
        $this->assertFalse($stringPermission);
    }


    public function testHasAnyAccess(): void
    {
        $user = $this->createUser();

        // User permissions
        $this->assertTrue($user->hasAnyAccess('access.to.public.data'));
        $this->assertFalse($user->hasAnyAccess('access.to.secret.data'));

        $this->assertTrue($user->hasAnyAccess([
            'access.to.public.data',
            'access.to.secret.data',
        ]));
    }

    public function testHasAnyEmptyAccess(): void
    {
        $user = $this->createUser();

        $this->assertTrue($user->hasAnyAccess([]));
    }

    /**
     * Permissions can be checked based on wildcards
     * using the * character to match any of a set of permissions.
     */
    public function testWildcardChecksPermission(): void
    {
        $permission = $this->createUser()->hasAccess('access.user.*');

        $this->assertTrue($permission);
    }
}
