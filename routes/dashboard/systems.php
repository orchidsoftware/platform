<?php

/*
|--------------------------------------------------------------------------
| Systems Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->group([
    'middleware' => ['web', 'dashboard', 'access'],
    'prefix'     => 'dashboard/systems',
    'namespace'  => 'Orchid\Platform\Http\Controllers\Systems',
],
    function (\Illuminate\Routing\Router $router) {
        $router->resource('users', 'UserController', ['names' => [
            'index'   => 'dashboard.systems.users',
            'create'  => 'dashboard.systems.users.create',
            'edit'    => 'dashboard.systems.users.edit',
            'update'  => 'dashboard.systems.users.update',
            'store'   => 'dashboard.systems.users.store',
            'destroy' => 'dashboard.systems.users.destroy',
        ]]);

        $router->resource('roles', 'RoleController', ['names' => [
            'index'   => 'dashboard.systems.roles',
            'create'  => 'dashboard.systems.roles.create',
            'edit'    => 'dashboard.systems.roles.edit',
            'update'  => 'dashboard.systems.roles.update',
            'store'   => 'dashboard.systems.roles.store',
            'destroy' => 'dashboard.systems.roles.destroy',
        ]]);

        $router->get('cache', [
            'as'   => 'dashboard.systems.cache',
            'uses' => 'CacheController@index',
        ]);

        $router->post('cache', [
            'as'   => 'dashboard.systems.cache',
            'uses' => 'CacheController@store',
        ]);

        $router->post('notification/read', [
            'as'   => 'dashboard.notification.read',
            'uses' => 'NotificationController@markAllAsRead',
        ]);

        $router->post('notification/remove', [
            'as'   => 'dashboard.notification.remove',
            'uses' => 'NotificationController@remove',
        ]);
    });
