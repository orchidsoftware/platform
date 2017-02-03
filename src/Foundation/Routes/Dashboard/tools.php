<?php

/*
|--------------------------------------------------------------------------
| Tools Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

Route::group(['middleware' => ['web'], 'prefix' => 'dashboard/tools', 'namespace' => 'Orchid\Foundation\Http\Controllers\Tools'],
    function ($router) {

        Route::post('files', [
            'as' => 'dashboard.tools.files.upload',
            'uses' => 'AttachmentController@upload',
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
            'uses' => 'AttachmentController@upload',
        ]);
        Route::delete('files/{id}', [
            'as' => 'dashboard.tools.files.destroy',
            'uses' => 'AttachmentController@destroy',
        ]);

        Route::get('files/post/{id}', [
            'as' => 'dashboard.tools.files.destroy',
            'uses' => 'AttachmentController@getFilesPost',
        ]);

        Route::resource('menu', 'MenuController', ['names' => [
            'index' => 'dashboard.tools.menu.index',
            'show' => 'dashboard.tools.menu.show',
            'update' => 'dashboard.tools.menu.update',
        ]]);

    });
