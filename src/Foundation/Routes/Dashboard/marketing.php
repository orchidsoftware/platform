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
    'middleware' => ['web', 'dashboard'],
    'prefix' => 'dashboard/marketing',
    'namespace' => 'Orchid\Foundation\Http\Controllers\Marketing',
],
    function ($router) {
        $router->resource('comment', 'CommentController', ['names' => [
            'index' => 'dashboard.marketing.comment',
            'create' => 'dashboard.marketing.comment.create',
            'edit' => 'dashboard.marketing.comment.edit',
            'update' => 'dashboard.marketing.comment.update',
            'store' => 'dashboard.marketing.comment.store',
            'destroy' => 'dashboard.marketing.comment.destroy',
        ]]);
    });
