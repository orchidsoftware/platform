<?php


Route::group(['namespace' => 'Posts', 'prefix' => 'posts'], function () {
    Route::get('{type}/create', [
        'as' => 'dashboard.posts.type.create',
        'uses' => 'PostController@create',
    ]);

    Route::get('{type}/{slug}/edit', [
        'as' => 'dashboard.posts.type.edit',
        'uses' => 'PostController@edit',
    ]);

    Route::get('{type}/{slug?}', [
        'as' => 'dashboard.posts.type',
        'uses' => 'PostController@index',
    ]);

    Route::post('{type}', [
        'as' => 'dashboard.posts.type.store',
        'uses' => 'PostController@store',
    ]);

    Route::put('{type}/{slug?}', [
        'as' => 'dashboard.posts.type.update',
        'uses' => 'PostController@update',
    ]);

    Route::delete('{type}/{slug?}', [
        'as' => 'dashboard.posts.type.destroy',
        'uses' => 'PostController@destroy',
    ]);
});