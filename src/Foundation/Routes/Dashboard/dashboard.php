<?php


/*
|--------------------------------------------------------------------------
| Dashboard Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->group(['middleware' => ['web'], 'prefix' => 'dashboard', 'namespace' => 'Orchid\Foundation\Http\Controllers'],
    function ($router) {
        $router->get('/', [
            'as'   => 'dashboard.index',
            'uses' => 'DashboardController@index',
        ]);
    });
