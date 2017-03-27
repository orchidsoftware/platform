<?php

/*
|--------------------------------------------------------------------------
| Tools Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->group([
    'middleware' => ['web', 'dashboard'],
    'prefix'     => 'dashboard/tools',
    'namespace'  => 'Orchid\Http\Controllers\Tools',
],
    function (\Illuminate\Routing\Router $router) {
        $router->resource('category', 'CategoryController', ['names' => [
            'index'   => 'dashboard.tools.category',
            'create'  => 'dashboard.tools.category.create',
            'edit'    => 'dashboard.tools.category.edit',
            'update'  => 'dashboard.tools.category.update',
            'store'   => 'dashboard.tools.category.store',
            'destroy' => 'dashboard.tools.category.destroy',
        ]]);

        $router->post('files', [
            'as'   => 'dashboard.tools.files.upload',
            'uses' => 'AttachmentController@upload',
        ]);

        $router->post('files/sort', [
            'as'   => 'dashboard.tools.files.sort',
            'uses' => 'AttachmentController@sort',
        ]);

        $router->delete('files/{id}', [
            'as'   => 'dashboard.tools.files.destroy',
            'uses' => 'AttachmentController@destroy',
        ]);

        $router->get('files/post/{id}', [
            'as'   => 'dashboard.tools.files.destroy',
            'uses' => 'AttachmentController@getFilesPost',
        ]);

        $router->resource('menu', 'MenuController', ['names' => [
            'index'  => 'dashboard.tools.menu.index',
            'show'   => 'dashboard.tools.menu.show',
            'update' => 'dashboard.tools.menu.update',
        ]]);

        Route::group([
            'as'     => 'dashboard.tools.media.',
            'prefix' => 'media',
        ], function () {
            Route::get('/', ['uses' => 'MediaController@index', 'as' => 'index']);
            Route::post('files', ['uses' => 'MediaController@files', 'as' => 'files']);
            Route::post('new_folder', ['uses' => 'MediaController@newFolder', 'as' => 'new_folder']);
            Route::post('delete_file_folder', ['uses' => 'MediaController@deleteFileFolder', 'as' => 'delete_file_folder']);
            Route::post('directories', ['uses' => 'MediaController@getAllDirs', 'as' => 'get_all_dirs']);
            Route::post('move_file', ['uses' => 'MediaController@moveFile', 'as' => 'move_file']);
            Route::post('rename_file', ['uses' => 'MediaController@renameFile', 'as' => 'rename_file']);
            Route::post('upload', ['uses' => 'MediaController@upload', 'as' => 'upload']);
            Route::post('remove', ['uses' => 'MediaController@remove', 'as' => 'remove']);
        });
    });
