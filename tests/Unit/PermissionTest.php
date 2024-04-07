<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Exception;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Models\User;
use Orchid\Platform\Orchid;
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
                'scoped.by.permission'  => 1,
            ],
        ]);
    }

    private function createAltUser(): User
    {
        return User::firstOrCreate([
            'email' => 'test_alt@test.com',
        ], [
            'name'        => 'test alternative user',
            'email'       => 'test_alt@test.com',
            'password'    => 'password',
            'permissions' => [
                'access.to.public.data'    => 1,
                'alt.scoped.by.permission' => 1,
            ],
        ]);
    }

    private function createNoPermissionsUser(): User
    {
        return User::firstOrCreate([
            'email' => 'no_permissions@test.com',
        ], [
            'name'        => 'user without permissions',
            'email'       => 'no_permissions@test.com',
            'password'    => 'password',
            'permissions' => [],
        ]);
    }

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
        $dashboard = new Orchid();

        $permission = ItemPermission::group('Test')
            ->addPermission('test', 'Test Description');

        $dashboard->registerPermissions($permission);

        $this->assertEquals(1, $dashboard->getPermission()->count());
    }

    /**
     * Dashboard registered permission by group.
     */
    public function testGetPermissionsByGroup(): void
    {
        $dashboard = new Orchid();

        $permissionA = ItemPermission::group('Test-A')
            ->addPermission('test_a', 'Test Description A');

        $permissionB = ItemPermission::group('Test-B')
            ->addPermission('test_b', 'Test Description B');

        $dashboard->registerPermissions($permissionA);
        $dashboard->registerPermissions($permissionB);

        $this->assertEquals(['Test-A', 'Test-B'], $dashboard->getPermission()->keys()->toArray());
        $this->assertEquals(['Test-A'], $dashboard->getPermission(['Test-A'])->keys()->toArray());
    }

    /**
     * Dashboard remove permission.
     */
    public function testIsWasRemovedPermission(): void
    {
        $dashboard = new Orchid();
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

    public function testScopeByAccess(): void
    {
        $user = $this->createUser();
        $userAlt = $this->createAltUser();
        $this->createNoPermissionsUser();

        $role = $this->createRole();
        $user->addRole($role);

        // Empty permission, gets no users
        $this->assertEmpty(User::byAccess('')->get());

        // Unexisting permission
        $this->assertEmpty(User::byAccess('unexisting.permission')->get());

        // Not allowed permission
        $this->assertTrue(User::byAccess('access.to.secret.data')->get()->isEmpty());

        // Scope single user by user permission
        $users = User::byAccess('alt.scoped.by.permission')->get();
        $this->assertEquals(1, $users->count());
        $this->assertTrue($users->contains($userAlt));

        // Scope multiple users by user permission
        $users = User::byAccess('access.to.public.data')->get();
        $this->assertEquals(2, $users->count());
        $this->assertTrue($users->contains($user));
        $this->assertTrue($users->contains($userAlt));

        // Scope single user by role permission
        $users = User::byAccess('access.roles.to.public.data')->get();
        $this->assertEquals(1, $users->count());
        $this->assertTrue($users->contains($user));

        // Scope multiple users by role permission

        $userAlt->addRole($role);

        $users = User::byAccess('access.roles.to.public.data')->get();
        $this->assertEquals(2, $users->count());
        $this->assertTrue($users->contains($user));
        $this->assertTrue($users->contains($userAlt));
    }

    public function testScopeByAnyAccess(): void
    {
        $user = $this->createUser();
        $userAlt = $this->createAltUser();
        $this->createNoPermissionsUser();

        $role = $this->createRole();
        $user->addRole($role);

        // No permission specified, gets no users
        $this->assertEmpty(User::byAnyAccess([])->get());

        // Empty permissions
        $this->assertEmpty(User::byAnyAccess([
            'unexisting.permission',
            'unexisting.second.permission',
        ])->get());

        // Not allowed permission
        $this->assertTrue(User::byAnyAccess([
            'unexisting.permission',
            'access.to.secret.data',
        ])->get()->isEmpty());

        // Scope single user by user permission
        $users = User::byAnyAccess([
            'unexisting.permission',
            'alt.scoped.by.permission',
        ])->get();
        $this->assertEquals(1, $users->count());
        $this->assertTrue($users->contains($userAlt));

        // Scope multiple users by user permissions
        $users = User::byAnyAccess([
            'scoped.by.permission',
            'alt.scoped.by.permission',
        ])->get();
        $this->assertEquals(2, $users->count());
        $this->assertTrue($users->contains($user));
        $this->assertTrue($users->contains($userAlt));

        // Scope single user by role permission
        $users = User::byAnyAccess([
            'unexisting.permission',
            'access.roles.to.public.data',
        ])->get();
        $this->assertEquals(1, $users->count());
        $this->assertTrue($users->contains($user));

        // Scope single user by user and role permission
        $users = User::byAnyAccess([
            'scoped.by.permission',
            'access.roles.to.public.data',
        ])->get();
        $this->assertEquals(1, $users->count());
        $this->assertTrue($users->contains($user));

        // Alt user is now admin test role too
        $userAlt->addRole($role);

        // Scope multiple users by role permission
        $users = User::byAnyAccess([
            'unexisting.permission',
            'access.roles.to.public.data',
        ])->get();
        $this->assertEquals(2, $users->count());
        $this->assertTrue($users->contains($user));
        $this->assertTrue($users->contains($userAlt));
    }
}
