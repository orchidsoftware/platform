<?php

Route::get('/', [
    'as'   => 'dashboard.index',
    'uses' => 'DashboardController@index',
]);


Route::group(['namespace' => 'Posts',  'prefix' => 'posts'], function () {
});

Route::group(['namespace' => 'Systems', 'prefix' => 'systems'], function () {
    Route::get('settings', [
        'as'   => 'dashboard.systems.settings',
        'uses' => 'SettingController@index',
    ]);

    Route::get('localization', [
        'as'   => 'dashboard.systems.localization',
        'uses' => 'LocalizationController@index',
    ]);


    Route::resource('users', 'UserController', ['names' => [
        'index'  => 'dashboard.systems.users',
        'create' => 'dashboard.systems.users.create',
        'edit'   => 'dashboard.systems.users.edit',
        'update'  => 'dashboard.systems.users.update',
        'store'  => 'dashboard.systems.users.store',
        'destroy' => 'dashboard.systems.users.destroy'
    ]]);


    Route::resource('roles', 'RoleController', ['names' => [
        'index'  => 'dashboard.systems.roles',
        'create' => 'dashboard.systems.roles.create',
        'edit'   => 'dashboard.systems.roles.edit',
        'update'  => 'dashboard.systems.roles.update',
        'store'  => 'dashboard.systems.roles.store',
        'destroy' => 'dashboard.systems.roles.destroy'
    ]]);
});

Route::group(['namespace' => 'Tools',  'prefix' => 'tools'], function () {
});
