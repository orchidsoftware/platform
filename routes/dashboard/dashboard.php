<?php

/*
|--------------------------------------------------------------------------
| Dashboard Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->group([
    'middleware' => ['web', 'dashboard', 'access'],
    'prefix'     => 'dashboard',
    'namespace'  => 'Orchid\Platform\Http\Controllers',
],
    function (\Illuminate\Routing\Router $router) {
        $router->get('/', [
            'as'   => 'dashboard.index',
            'uses' => 'DashboardController@index',
        ]);
    });
