<?php

/*
|--------------------------------------------------------------------------
| Dashboard Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->domain(config('platform.domain'))->group(function () {
    $this->group([
        'middleware' => config('platform.middleware.private'),
        'prefix'     => \Orchid\Platform\Dashboard::prefix(),
        'namespace'  => 'Orchid\Platform\Http\Controllers',
    ], function (\Illuminate\Routing\Router $router) {
        $router->get('/', [
            'as'   => 'platform.index',
            'uses' => 'DashboardController@index',
        ]);
    });
});
