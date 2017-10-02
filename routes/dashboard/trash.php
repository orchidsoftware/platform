<?php

/*
|--------------------------------------------------------------------------
| Trash
|--------------------------------------------------------------------------
|
| Remove 2.0
|
*/

$this->group([
    'middleware' => ['web', 'dashboard', 'access'],
    'prefix'     => 'dashboard/systems',
    'namespace'  => 'Orchid\Platform\Http\Controllers\Systems',
],
    function (\Illuminate\Routing\Router $router) {

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
    });

$this->group([
    'middleware' => ['web', 'dashboard', 'access'],
    'prefix'     => 'dashboard/marketing',
    'namespace'  => 'Orchid\Platform\Http\Controllers\Marketing',
],
    function (\Illuminate\Routing\Router $router) {

        $router->get('utm', 'UTMController@index')->name('dashboard.marketing.utm.index');

        $router->resource('robots', 'RobotsController', [
            'names' => [
                'index' => 'dashboard.marketing.robots.index',
                'store' => 'dashboard.marketing.robots.store',
            ],
        ]);
    });
