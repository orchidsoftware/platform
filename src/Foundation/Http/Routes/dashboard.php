<?php

Route::get('/', [
    'as'   => 'dashboard.index',
    'uses' => 'DashboardController@index',
]);


Route::group(['namespace' => 'Posts',  'prefix' => 'posts'], function () {
    Route::get('{type}/create', [
        'as'   => 'dashboard.posts.type.create',
        'uses' => 'PostController@create',
    ]);

    Route::get('{type}/{slug?}', [
        'as'   => 'dashboard.posts.type',
        'uses' => 'PostController@index',
    ]);



    Route::get('{type}/edit', [
        'as'   => 'dashboard.posts.type.edit',
        'uses' => 'PostController@index',
    ]);

    Route::post('{type}', [
        'as'   => 'dashboard.posts.type.store',
        'uses' => 'PostController@index',
    ]);

    Route::put('{type}/{slug?}', [
        'as'   => 'dashboard.posts.type.update',
        'uses' => 'PostController@index',
    ]);

    Route::delete('{type}/{slug?}', [
        'as'   => 'dashboard.posts.type.destroy',
        'uses' => 'PostController@index',
    ]);


    /*
    foreach ($posts as $post){

        $type = $post->slug;

        Route::get("{{$type}}/{{$type}-slug?}",[
            'as'   => "dashboard.posts.$post->slug",
            'uses' => 'PostController@index',
        ]);





        Route::resource($post->slug, 'PostController', ['names' => [
            'index'  => "dashboard.posts.$post->slug",
            'create' => "dashboard.posts.$post->slug.create",
            'edit'   => "dashboard.posts.$post->slug.edit",
            'update'  => "dashboard.posts.$post->slug.update",
            'store'  => "dashboard.posts.$post->slug.store",
            'destroy' => "dashboard.posts.$post->slug.destroy",
        ]]);



    }
    */
});

Route::group(['namespace' => 'Systems', 'prefix' => 'systems'], function () {
    Route::get('settings', [
        'as'   => 'dashboard.systems.settings',
        'uses' => 'SettingController@index',
    ]);
    Route::post('settings', [
        'as'   => 'dashboard.systems.settings',
        'uses' => 'SettingController@store',
    ]);




    Route::resource('localization', 'LocalizationController', ['names' => [
        'index' => 'dashboard.systems.localization',
        'create' => 'dashboard.systems.localization.create',
        'edit' => 'dashboard.systems.localization.edit',
        'store' => 'dashboard.systems.localization.store',
    ]]);


    Route::resource('users', 'UserController', ['names' => [
        'index'  => 'dashboard.systems.users',
        'create' => 'dashboard.systems.users.create',
        'edit'   => 'dashboard.systems.users.edit',
        'update'  => 'dashboard.systems.users.update',
        'store'  => 'dashboard.systems.users.store',
        'destroy' => 'dashboard.systems.users.destroy',
    ]]);


    Route::resource('roles', 'RoleController', ['names' => [
        'index'  => 'dashboard.systems.roles',
        'create' => 'dashboard.systems.roles.create',
        'edit'   => 'dashboard.systems.roles.edit',
        'update'  => 'dashboard.systems.roles.update',
        'store'  => 'dashboard.systems.roles.store',
        'destroy' => 'dashboard.systems.roles.destroy',
    ]]);
});

Route::group(['namespace' => 'Tools',  'prefix' => 'tools'], function () {
});
