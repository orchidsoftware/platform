<?php

/*
|--------------------------------------------------------------------------
| Post Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->domain(config('platform.domain'))->group(function () {
    $this->group([
        'middleware' => config('platform.middleware.private'),
        'prefix'     => \Orchid\Platform\Kernel\Dashboard::prefix('/posts'),
        'namespace'  => 'Orchid\Platform\Http\Controllers\Posts',
    ], function (\Illuminate\Routing\Router $router) {
        $router->get('{dashboard_type}/create', [
            'as'   => 'dashboard.posts.type.create',
            'uses' => 'PostController@create',
        ]);

        $router->get('{dashboard_type}/{dashboard_slug}/edit', [
            'as'   => 'dashboard.posts.type.edit',
            'uses' => 'PostController@edit',
        ]);

        $router->get('{dashboard_type}/{dashboard_slug?}', [
            'as'   => 'dashboard.posts.type',
            'uses' => 'PostController@index',
        ]);

        $router->post('{dashboard_type}', [
            'as'   => 'dashboard.posts.type.store',
            'uses' => 'PostController@store',
        ]);

        $router->put('{dashboard_type}/{dashboard_slug?}', [
            'as'   => 'dashboard.posts.type.update',
            'uses' => 'PostController@update',
        ]);

        $router->delete('{dashboard_type}/{dashboard_slug?}', [
            'as'   => 'dashboard.posts.type.destroy',
            'uses' => 'PostController@destroy',
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | Page Web Routes
    |--------------------------------------------------------------------------
    |
    | Base route
    |
    */

    $this->group([
        'middleware' => config('platform.middleware.private'),
        'prefix'     => \Orchid\Platform\Kernel\Dashboard::prefix('/pages'),
        'namespace'  => 'Orchid\Platform\Http\Controllers\Posts',
    ], function (\Illuminate\Routing\Router $router) {
        $router->get('{dashboard_page}', [
            'as'   => 'dashboard.pages.show',
            'uses' => 'PageController@show',
        ]);

        $router->put('{dashboard_page}', [
            'as'   => 'dashboard.pages.update',
            'uses' => 'PageController@update',
        ]);
    });
});
