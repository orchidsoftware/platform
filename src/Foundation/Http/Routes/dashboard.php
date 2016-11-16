<?php

Route::get('/', [
    'as' => 'dashboard.index',
    'uses' => 'DashboardController@index',
]);


Route::group(['namespace' => 'Posts',  'prefix' => 'posts'], function () {
});

Route::group(['namespace' => 'Systems', 'prefix' => 'systems'], function () {
    Route::get('settings', [
        'as' => 'dashboard.systems.settings',
        'uses' => 'SettingController@index',
    ]);

    Route::resource('localization', 'LocalizationController', ['names' => [
        'index' => 'dashboard.systems.localization',
        'create' => 'dashboard.systems.localization.add',
//        'edit' => 'dashboard.systems.roles.edit',
//        'store' => 'dashboard.systems.roles.store'
    ]]);

    Route::resource('roles', 'RoleController', ['names' => [
        'index' => 'dashboard.systems.roles',
        'create' => 'dashboard.systems.roles.create',
        'edit' => 'dashboard.systems.roles.edit',
        'store' => 'dashboard.systems.roles.store'
    ]]);
});

Route::group(['namespace' => 'Tools',  'prefix' => 'tools'], function () {
});
