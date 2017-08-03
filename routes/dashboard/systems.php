<?php

/*
|--------------------------------------------------------------------------
| Systems Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->group(
    [
    'middleware' => ['web', 'dashboard', 'access'],
    'prefix'     => 'dashboard/systems',
    'namespace'  => 'Orchid\Http\Controllers\Systems',
],
    function (\Illuminate\Routing\Router $router) {
        $router->get('settings', [
            'as'   => 'dashboard.systems.settings',
            'uses' => 'SettingController@index',
        ]);

        $router->post('settings', [
            'as'   => 'dashboard.systems.settings',
            'uses' => 'SettingController@store',
        ]);

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

        $router->resource('backup', 'BackupController', ['names' => [
            'index' => 'dashboard.systems.backup',
            'show'  => 'dashboard.systems.backup.download',
        ]]);

        $router->resource('schema', 'SchemaController', ['names' => [
            'index' => 'dashboard.systems.schema.index',
            'show'  => 'dashboard.systems.schema.show',
        ]]);

        $router->resource('logs', 'LogController', ['names' => [
            'index'    => 'dashboard.systems.logs.index',
            'show'     => 'dashboard.systems.logs.show',
            'download' => 'dashboard.systems.logs.show',
            'destroy'  => 'dashboard.systems.logs.destroy',
        ]]);

        $router->resource('defender', 'DefenderController', ['names' => [
            'index' => 'dashboard.systems.defender.index',
        ]]);

        $router->get('monitor', [
            'as'   => 'dashboard.systems.monitor',
            'uses' => 'MonitorController@index',
        ]);

        $router->get('cache', [
            'as'   => 'dashboard.systems.cache',
            'uses' => 'CacheController@index',
        ]);

        $router->post('cache', [
            'as'   => 'dashboard.systems.cache',
            'uses' => 'CacheController@store',
        ]);
    }
);
