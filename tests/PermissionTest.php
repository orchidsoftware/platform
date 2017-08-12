<?php

namespace Orchid\Platform\Tests;

use Orchid\Platform\Core\Models\Role;
use Orchid\Platform\Core\Models\User;
use Orchid\Platform\Kernel\Dashboard;

class PermissionTest extends TestCase
{
    /**
     * Verify permissions.
     */
    public function test_is_permission()
    {
        $user = $this->createUser();

        // User permissions
        $this->assertEquals($user->hasAccess('access.to.public.data'), true);
        $this->assertEquals($user->hasAccess('access.to.secret.data'), false);
        $this->assertEquals($user->hasAccess('access.roles.to.public.data'), false);

        $role = $this->createRole();
        $user->addRole($role);

        // User of role
        $this->assertEquals($user->getRoles()->count(), 1);
        $this->assertEquals($role->getUsers()->count(), 1);
        $this->assertEquals($user->inRole('admin'), true);

        // Role permissions
        $this->assertEquals($user->hasAccess('access.roles.to.public.data'), true);
    }

    /**
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    private function createUser()
    {
        return User::create([
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
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public function createRole()
    {
        return Role::create([
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
    public function test_is_registered_permission()
    {
        $dashboard = new Dashboard();

        $dashboard->permission->registerPermissions([
            'Test' => [
                [
                    'slug'        => 'test',
                    'description' => 'Test Description',
                ],
            ],
        ]);

        $this->assertEquals($dashboard->permission->get()->count(), 1);
    }
}
