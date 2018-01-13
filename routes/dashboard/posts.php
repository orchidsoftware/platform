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
        $router->get('{orchidType}/create', [
            'as'   => 'dashboard.posts.type.create',
            'uses' => 'PostController@create',
        ]);

        $router->get('{orchidType}/{orchidSlug}/edit', [
            'as'   => 'dashboard.posts.type.edit',
            'uses' => 'PostController@edit',
        ]);

        $router->get('{orchidType}/{orchidSlug?}', [
            'as'   => 'dashboard.posts.type',
            'uses' => 'PostController@index',
        ]);

        $router->post('{orchidType}', [
            'as'   => 'dashboard.posts.type.store',
            'uses' => 'PostController@store',
        ]);

        $router->put('{orchidType}/{orchidSlug?}', [
            'as'   => 'dashboard.posts.type.update',
            'uses' => 'PostController@update',
        ]);

        $router->delete('{orchidType}/{orchidSlug?}', [
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
        $router->get('{orchidPage}', [
            'as'   => 'dashboard.pages.show',
            'uses' => 'PageController@show',
        ]);

        $router->put('{orchidPage}', [
            'as'   => 'dashboard.pages.update',
            'uses' => 'PageController@update',
        ]);
    });
});
