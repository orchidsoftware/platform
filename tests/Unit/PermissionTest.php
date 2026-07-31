<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Exception;
use Illuminate\Support\Collection;
use Orchid\Access\PermissionGroup;
use Orchid\Access\Permissions;
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
        $this->assertEquals(1, $user->roles()->count());
        $this->assertEquals(1, $role->users()->count());
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
            'name' => 'admin',
        ], [
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
        $dashboard = new Orchid;

        $permission = PermissionGroup::group('Test')
            ->permission('test', 'Test Description');

        $dashboard->registerPermissions($permission);

        $this->assertEquals(1, $dashboard->getPermission()->count());
    }

    /**
     * Dashboard registered permission by group.
     */
    public function testGetPermissionsByGroup(): void
    {
        $dashboard = new Orchid;

        $permissionA = PermissionGroup::group('Test-A')
            ->permission('test_a', 'Test Description A');

        $permissionB = PermissionGroup::group('Test-B')
            ->permission('test_b', 'Test Description B');

        $dashboard->registerPermissions($permissionA);
        $dashboard->registerPermissions($permissionB);

        $this->assertEquals(['Test-A', 'Test-B'], $dashboard->getPermission()->keys()->toArray());
        $this->assertEquals(['Test-A'], $dashboard->getPermission(['Test-A'])->keys()->toArray());
    }

    public function testRegisterPermissionMergesItemsIntoExistingGroup(): void
    {
        $dashboard = new Orchid;

        $dashboard->registerPermission(
            PermissionGroup::group('Reports')
                ->permission('reports.view', 'View reports')
        );

        $dashboard->registerPermission(
            PermissionGroup::group('Reports')
                ->permission('reports.export', 'Export reports')
        );

        $this->assertSame([
            [
                'slug'        => 'reports.view',
                'description' => 'View reports',
            ],
            [
                'slug'        => 'reports.export',
                'description' => 'Export reports',
            ],
        ], $dashboard->getPermission('Reports')->collapse()->values()->toArray());
    }

    public function testGetAllowAllPermissionReturnsPermissionsValueObject(): void
    {
        $dashboard = new Orchid;

        $dashboard->registerPermissions(
            PermissionGroup::group('Test')
                ->permission('test.view', 'View')
                ->permission('test.update', 'Update')
        );

        $permissions = $dashboard->getAllowAllPermission();

        $this->assertInstanceOf(Permissions::class, $permissions);
        $this->assertSame([
            'test.view'   => true,
            'test.update' => true,
        ], $permissions->toArray());
    }

    public function testPermissionDescriptionIsNotStoredWithAssignedPermissions(): void
    {
        $permissions = Permissions::fromItems(
            PermissionGroup::group('Reports')
                ->permission('reports.view', 'View reports')
                ->items()
        );

        $user = User::factory()->create([
            'permissions' => $permissions,
        ]);

        $this->assertSame([
            'reports.view' => true,
        ], $permissions->toArray());

        $this->assertSame([
            'reports.view' => true,
        ], json_decode((string) $user->getRawOriginal('permissions'), true));
    }

    public function testUserPermissionsAreCastedToValueObject(): void
    {
        $user = User::factory()->create([
            'permissions' => [
                'access.to.public.data' => '1',
                'access.to.secret.data' => 'false',
                'access.to.*'           => true,
            ],
        ]);

        $this->assertInstanceOf(Permissions::class, $user->permissions);
        $this->assertSame([
            'access.to.public.data' => true,
            'access.to.secret.data' => false,
            'access.to.*'           => true,
        ], $user->permissions->toArray());
        $this->assertTrue($user->permissions->allows('access.to.public.data'));
        $this->assertTrue($user->permissions->allows('access.to.anything'));
        $this->assertTrue($user->permissions->isActive('access.to.public.data'));
        $this->assertFalse($user->permissions->isActive('access.to.secret.data'));
        $this->assertFalse($user->permissions->allows('other.permission'));
    }

    public function testPermissionsReturnSameInstanceWhenAlreadyNormalized(): void
    {
        $permissions = Permissions::make([
            'reports.view' => true,
        ]);

        $this->assertSame($permissions, Permissions::make($permissions));
    }

    public function testPermissionsConstructorNormalizesItems(): void
    {
        $permissions = new Permissions([
            'reports.view'   => 1,
            'reports.delete' => 'false',
            ''               => true,
        ]);

        $this->assertSame([
            'reports.view'   => true,
            'reports.delete' => false,
        ], $permissions->toArray());
    }

    public function testPermissionsCanBeCreatedFromArrayableInput(): void
    {
        $permissions = Permissions::make(collect([
            'reports.view'   => '1',
            'reports.delete' => '0',
        ]));

        $this->assertSame([
            'reports.view'   => true,
            'reports.delete' => false,
        ], $permissions->toArray());
    }

    public function testPermissionsCanBeCreatedFromTraversableInput(): void
    {
        $permissions = Permissions::make(new \ArrayIterator([
            'reports.view'   => 1,
            'reports.delete' => 0,
        ]));

        $this->assertSame([
            'reports.view'   => true,
            'reports.delete' => false,
        ], $permissions->toArray());
    }

    public function testPermissionsCanBeCreatedFromJsonInput(): void
    {
        $permissions = Permissions::make('{"reports.view":true,"reports.delete":false}');

        $this->assertSame([
            'reports.view'   => true,
            'reports.delete' => false,
        ], $permissions->toArray());
    }

    public function testPermissionsIgnoreInvalidInput(): void
    {
        $this->assertSame([], Permissions::make(new \stdClass)->toArray());
        $this->assertSame([], Permissions::make('not-json')->toArray());
    }

    public function testPermissionsNormalizeBooleanLikeValues(): void
    {
        $permissions = Permissions::make([
            'bool.true'    => true,
            'bool.false'   => false,
            'string.true'  => 'true',
            'string.false' => 'false',
            'string.one'   => '1',
            'string.zero'  => '0',
            'string.on'    => 'on',
            'string.off'   => 'off',
            'string.empty' => '',
            'string.name'  => 'allowed',
            'int.one'      => 1,
            'int.zero'     => 0,
        ]);

        $this->assertSame([
            'bool.true'    => true,
            'bool.false'   => false,
            'string.true'  => true,
            'string.false' => false,
            'string.one'   => true,
            'string.zero'  => false,
            'string.on'    => true,
            'string.off'   => false,
            'string.empty' => false,
            'string.name'  => true,
            'int.one'      => true,
            'int.zero'     => false,
        ], $permissions->toArray());
    }

    public function testPermissionsCanCountActiveItems(): void
    {
        $permissions = Permissions::make([
            'reports.view'   => true,
            'reports.create' => 1,
            'reports.delete' => false,
        ]);

        $this->assertSame(2, $permissions->count());
        $this->assertCount(2, $permissions);
    }

    public function testPermissionsAreStoredAsJsonBooleans(): void
    {
        $user = User::factory()->create([
            'permissions' => [
                'reports.view'   => true,
                'reports.create' => 1,
                'reports.delete' => 0,
            ],
        ]);

        $this->assertSame([
            'reports.view'   => true,
            'reports.create' => true,
            'reports.delete' => false,
        ], json_decode((string) $user->getRawOriginal('permissions'), true));

        $this->assertSame('{"reports.view":true,"reports.create":true,"reports.delete":false}', $user->getRawOriginal('permissions'));
    }

    public function testPermissionsAreLoadedFromLegacyJsonNumbers(): void
    {
        $user = new User;

        $user->setRawAttributes([
            'permissions' => '{"reports.view":1,"reports.delete":0}',
        ], true);

        $this->assertInstanceOf(Permissions::class, $user->permissions);
        $this->assertSame([
            'reports.view'   => true,
            'reports.delete' => false,
        ], $user->permissions->toArray());
    }

    public function testPermissionsIgnoreInvalidPermissionKeys(): void
    {
        $permissions = Permissions::make([
            'reports.view' => true,
            ''             => true,
            123            => true,
        ]);

        $this->assertSame([
            'reports.view' => true,
        ], $permissions->toArray());
    }

    public function testUserCanBeGivenPermissionsManually(): void
    {
        $user = User::factory()->create([
            'permissions' => [],
        ]);

        $user
            ->forceFill([
                'permissions' => Permissions::make([
                    'reports.view'   => true,
                    'reports.delete' => false,
                ]),
            ])
            ->save();

        $user->refresh();

        $this->assertTrue($user->hasAccess('reports.view'));
        $this->assertFalse($user->hasAccess('reports.delete'));
        $this->assertSame([
            'reports.view'   => true,
            'reports.delete' => false,
        ], $user->permissions->toArray());
        $this->assertSame([
            'reports.view'   => true,
            'reports.delete' => false,
        ], json_decode((string) $user->getRawOriginal('permissions'), true));
    }

    public function testUserCanBeGivenPermissionsAsPlainArray(): void
    {
        $user = User::factory()->create([
            'permissions' => [
                'reports.view' => true,
            ],
        ]);

        $user->refresh();

        $this->assertInstanceOf(Permissions::class, $user->permissions);
        $this->assertTrue($user->hasAccess('reports.view'));
        $this->assertSame([
            'reports.view' => true,
        ], $user->permissions->toArray());
    }

    public function testRolePermissionsAreCastedToValueObject(): void
    {
        $role = Role::factory()->create([
            'permissions' => Permissions::make([
                'role.view'   => true,
                'role.update' => false,
            ]),
        ]);

        $role->refresh();

        $this->assertInstanceOf(Permissions::class, $role->permissions);
        $this->assertSame([
            'role.view'   => true,
            'role.update' => false,
        ], $role->permissions->toArray());
        $this->assertSame(1, $role->permissions->count());
    }

    public function testPermissionsCanBeCreatedFromFormInput(): void
    {
        $permissions = Permissions::fromForm([
            base64_encode('users.edit')   => '1',
            base64_encode('users.delete') => 'false',
            'not-base64'                  => '1',
        ]);

        $this->assertSame([
            'users.edit'   => true,
            'users.delete' => false,
        ], $permissions->toArray());
    }

    /**
     * Dashboard remove permission.
     */
    public function testIsWasRemovedPermission(): void
    {
        $dashboard = new Orchid;
        $permission = PermissionGroup::group('Test')
            ->permission('test', 'Test Description');
        $dashboard->registerPermissions($permission);
        $dashboard->removePermission('test');
        $this->assertEmpty($dashboard->getPermission()->get('Test'));
    }

    public function testReplacePermission(): void
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
        $user->removeRoleBySlug($role->name);

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

        $roleUser = Role::factory()->create(['name' => 'User']);
        $roleModerator = Role::factory()->create(['name' => 'Moderator']);

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

    public function testRolePermissionsCountActiveItems(): void
    {
        $role = $this->createRole();

        $this->assertSame(2, $role->permissions->count());
    }

    public function testGetStatusPermissionReturnsAllPermissionsWithCorrectActiveFlags(): void
    {
        $user = User::factory()->create([
            'permissions' => [
                'orchid.attachment' => true,
            ],
        ]);

        $expectedPermissions = \Orchid\Support\Facades\Orchid::getPermission()
            ->map
            ->map(function ($permission) {
                $permission['active'] = in_array($permission['slug'], [
                    'orchid.attachment',
                ]);

                return $permission;
            });

        $resultPermissions = $user->getStatusPermission();

        $this->instance(Collection::class, $resultPermissions);
        $this->assertEquals($expectedPermissions, $resultPermissions);
    }
}
