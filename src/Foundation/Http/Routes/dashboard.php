<?php

Route::get('/', [
    'as' => 'dashboard.index',
    'uses' => 'DashboardController@index',
]);

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

Route::group(['namespace' => 'Systems', 'prefix' => 'systems'], function () {
    Route::get('settings', [
        'as' => 'dashboard.systems.settings',
        'uses' => 'SettingController@index',
    ]);

    Route::post('settings', [
        'as' => 'dashboard.systems.settings',
        'uses' => 'SettingController@store',
    ]);

    Route::resource('users', 'UserController', ['names' => [
        'index' => 'dashboard.systems.users',
        'create' => 'dashboard.systems.users.create',
        'edit' => 'dashboard.systems.users.edit',
        'update' => 'dashboard.systems.users.update',
        'store' => 'dashboard.systems.users.store',
        'destroy' => 'dashboard.systems.users.destroy',
    ]]);

    Route::resource('roles', 'RoleController', ['names' => [
        'index' => 'dashboard.systems.roles',
        'create' => 'dashboard.systems.roles.create',
        'edit' => 'dashboard.systems.roles.edit',
        'update' => 'dashboard.systems.roles.update',
        'store' => 'dashboard.systems.roles.store',
        'destroy' => 'dashboard.systems.roles.destroy',
    ]]);

    Route::resource('backup', 'BackupController', ['names' => [
        'index' => 'dashboard.systems.backup',
        'create' => 'dashboard.systems.backup.create',
        'download' => 'dashboard.systems.backup.download',
        'destroy' => 'dashboard.systems.backup.destroy',
    ]]);

    Route::get('/test1', [
        'as' => 'log-viewer::dashboard',
        'uses' => 'LogViewerController@index',
    ]);

    Route::get('/test2', [
        'as' => 'log-viewer::logs.list',
        'uses' => 'LogViewerController@listLogs',
    ]);

    Route::delete('delete', [
        'as' => 'log-viewer::logs.delete',
        'uses' => 'LogViewerController@delete',
    ]);

    Route::get('/test3/{test}', [
        'as' => 'log-viewer::logs.show',
        'uses' => 'LogViewerController@show',
    ]);

    Route::get('download', [
        'as' => 'log-viewer::logs.download',
        'uses' => 'LogViewerController@download',
    ]);

    Route::get('path-template', [
        'as' => 'dashboard::partials.path',
        'uses' => function () {
            return view('dashboard::partials.path');
        }
    ]);

    Route::get('icons', [
        'as' => 'dashboard::icons',
        'uses' => function() {
            $res = [
                ["code" => "ad", "icon" => "/bower_components/flag-icon-css/flags/1x1/ad.svg", "label" => "Метка 1"],
                ["code" => "ae", "icon" => "/bower_components/flag-icon-css/flags/1x1/ae.svg", "label" => "Метка 2"],
                ["code" => "af", "icon" => "/bower_components/flag-icon-css/flags/1x1/af.svg", "label" => "Метка 3"],
                ["code" => "ag", "icon" => "/bower_components/flag-icon-css/flags/1x1/ag.svg", "label" => "Метка 4"],
            ];

            return json_encode($res);
        }
    ]);

    $this->get('test4/{level}', [
        'as' => 'log-viewer::logs.filter',
        'uses' => 'LogViewerController@showByLevel',
    ]);
});

Route::group(['namespace' => 'Tools', 'prefix' => 'tools'], function () {
    Route::post('files', [
        'as' => 'dashboard.tools.files.upload',
        'uses' => 'FileController@upload',
    ]);

    Route::resource('section', 'SectionController', ['names' => [
        'index' => 'dashboard.tools.section',
        'create' => 'dashboard.tools.section.create',
        'edit' => 'dashboard.tools.section.edit',
        'update' => 'dashboard.tools.section.update',
        'store' => 'dashboard.tools.section.store',
        'destroy' => 'dashboard.tools.section.destroy',
    ]]);

    Route::post('files', [
        'as' => 'dashboard.tools.files.upload',
        'uses' => 'FileController@upload',
    ]);
    Route::delete('files/{id}', [
        'as' => 'dashboard.tools.files.destroy',
        'uses' => 'FileController@destroy',
    ]);

    Route::get('files/post/{id}', [
        'as' => 'dashboard.tools.files.destroy',
        'uses' => 'FileController@getFilesPost',
    ]);
});
