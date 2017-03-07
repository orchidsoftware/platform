<?php

/*
|--------------------------------------------------------------------------
| Post Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->group([
    'middleware' => ['web', 'dashboard'],
    'prefix'     => 'dashboard/posts',
    'namespace'  => 'Orchid\Http\Controllers\Posts',
],
    function (\Illuminate\Routing\Router $router) {
        $router->get('{type}/create', [
            'as'   => 'dashboard.posts.type.create',
            'uses' => 'PostController@create',
        ]);

        $router->get('{type}/{slug}/edit', [
            'as'   => 'dashboard.posts.type.edit',
            'uses' => 'PostController@edit',
        ]);

        $router->get('{type}/{slug?}', [
            'as'   => 'dashboard.posts.type',
            'uses' => 'PostController@index',
        ]);

        $router->post('{type}', [
            'as'   => 'dashboard.posts.type.store',
            'uses' => 'PostController@store',
        ]);

        $router->put('{type}/{slug?}', [
            'as'   => 'dashboard.posts.type.update',
            'uses' => 'PostController@update',
        ]);

        $router->delete('{type}/{slug?}', [
            'as'   => 'dashboard.posts.type.destroy',
            'uses' => 'PostController@destroy',
        ]);
    });
