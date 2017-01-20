<?php

/*
|--------------------------------------------------------------------------
| Tools Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

Route::group(['namespace' => 'Tools', 'prefix' => 'tools'], function () {
    Route::post('files', [
        'as'   => 'dashboard.tools.files.upload',
        'uses' => 'FileController@upload',
    ]);

    Route::resource('section', 'SectionController', ['names' => [
        'index'   => 'dashboard.tools.section',
        'create'  => 'dashboard.tools.section.create',
        'edit'    => 'dashboard.tools.section.edit',
        'update'  => 'dashboard.tools.section.update',
        'store'   => 'dashboard.tools.section.store',
        'destroy' => 'dashboard.tools.section.destroy',
    ]]);

    Route::post('files', [
        'as'   => 'dashboard.tools.files.upload',
        'uses' => 'FileController@upload',
    ]);
    Route::delete('files/{id}', [
        'as'   => 'dashboard.tools.files.destroy',
        'uses' => 'FileController@destroy',
    ]);

    Route::get('files/post/{id}', [
        'as'   => 'dashboard.tools.files.destroy',
        'uses' => 'FileController@getFilesPost',
    ]);

    Route::resource('menu', 'MenuController', ['names' => [
        'index'  => 'dashboard.tools.menu.index',
        'show'   => 'dashboard.tools.menu.show',
        'update' => 'dashboard.tools.menu.update',
    ]]);
});
