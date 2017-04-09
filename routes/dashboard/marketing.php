<?php


/*
|--------------------------------------------------------------------------
| Marketing Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->group([
    'middleware' => ['web', 'dashboard', 'access'],
    'prefix'     => 'dashboard/marketing',
    'namespace'  => 'Orchid\Http\Controllers\Marketing',
],
    function (\Illuminate\Routing\Router $router) {
        $router->resource('comment', 'CommentController', ['names' => [
            'index'   => 'dashboard.marketing.comment',
            'create'  => 'dashboard.marketing.comment.create',
            'edit'    => 'dashboard.marketing.comment.edit',
            'update'  => 'dashboard.marketing.comment.update',
            'store'   => 'dashboard.marketing.comment.store',
            'destroy' => 'dashboard.marketing.comment.destroy',
        ]]);

        $router->resource('advertising', 'AdvertisingController', ['names' => [
            'index'  => 'dashboard.marketing.advertising.index',
            'create' => 'dashboard.marketing.advertising.create',
            'edit'   => 'dashboard.marketing.advertising.edit',
            'update' => 'dashboard.marketing.advertising.update',
            'store'  => 'dashboard.marketing.advertising.store',
        ]]);

        $router->get('utm', 'UTMController@index')->name('dashboard.marketing.utm.index');

    });
