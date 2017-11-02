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
    'middleware' => config('platform.middleware.private'),
    'prefix'     => 'dashboard',
    'namespace'  => 'Orchid\Platform\Http\Controllers',
],
    function (\Illuminate\Routing\Router $router) {
        $router->get('/', [
            'as'   => 'dashboard.index',
            'uses' => 'DashboardController@index',
        ]);
    });
