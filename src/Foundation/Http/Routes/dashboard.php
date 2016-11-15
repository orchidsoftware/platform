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

    Route::resource('roles', 'RoleController', ['names' => [
        'index'  => 'dashboard.systems.roles',
        'create' => 'dashboard.systems.roles.create',
        'edit'   => 'dashboard.systems.roles.edit',
        'store'  => 'dashboard.systems.roles.store',
    ]]);
});

Route::group(['namespace' => 'Tools',  'prefix' => 'tools'], function () {
});
