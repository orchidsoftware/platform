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
    'middleware' => ['web', 'dashboard'],
    'prefix'     => 'dashboard/systems',
    'namespace'  => 'Orchid\Foundation\Http\Controllers\Systems',
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
            'index'    => 'dashboard.systems.backup',
            'create'   => 'dashboard.systems.backup.create',
            'download' => 'dashboard.systems.backup.download',
            'destroy'  => 'dashboard.systems.backup.destroy',
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

        //Удалить/Изменить
        $router->get('/logs2', [
            'as'   => 'log-viewer::logs.list',
            'uses' => 'LogController@listLogs',
        ]);

        //Удалить/Изменить
        $router->delete('delete', [
            'as'   => 'log-viewer::logs.delete',
            'uses' => 'LogController@delete',
        ]);

        //Удалить/Изменить
        $router->get('/test3/{test}', [
            'as'   => 'log-viewer::logs.show',
            'uses' => 'LogController@show',
        ]);

        //Удалить/Изменить
        $router->get('download', [
            'as'   => 'log-viewer::logs.download',
            'uses' => 'LogController@download',
        ]);

        /*
        * [LogicException]
        * Unable to prepare route [dashboard/systems/path-template] for serialization. Uses Closure.
        *


        Route::get('path-template', [
            'as'   => 'dashboard::partials.path',
            'uses' => function () {
                return view('dashboard::partials.path');
            },
        ]);


       Route::get('icons', [
           'as'   => 'dashboard::icons',
           'uses' => function () {
               $res = [
                   ['code' => 'ad', 'icon' => '/bower_components/flag-icon-css/flags/1x1/ad.svg', 'label' => 'Метка 1'],
                   ['code' => 'ae', 'icon' => '/bower_components/flag-icon-css/flags/1x1/ae.svg', 'label' => 'Метка 2'],
                   ['code' => 'af', 'icon' => '/bower_components/flag-icon-css/flags/1x1/af.svg', 'label' => 'Метка 3'],
                   ['code' => 'ag', 'icon' => '/bower_components/flag-icon-css/flags/1x1/ag.svg', 'label' => 'Метка 4'],
               ];

               return json_encode($res);
           },
       ]);
       */

        //Удалить/Изменить
        $router->get('test4/{level}', [
            'as'   => 'log-viewer::logs.filter',
            'uses' => 'LogController@showByLevel',
        ]);
    });
