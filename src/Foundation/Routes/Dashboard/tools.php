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
    'namespace'  => 'Orchid\Foundation\Http\Controllers\Tools',
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



        $router->get('/filemanager', 'FileManagerController@getIndex');
        $router->get('/filemanager/dialog', 'FileManagerController@getDialog');
        $router->post('/filemanager/get_folder', 'FileManagerController@ajaxGetFilesAndFolders');
        $router->post('/filemanager/uploadFile', 'FileManagerController@uploadFile');
        $router->post('/filemanager/createFolder', 'FileManagerController@createFolder');
        $router->post('/filemanager/delete', 'FileManagerController@delete');
        $router->get('/filemanager/download', 'FileManagerController@download')->where('path', '.*');
        $router->post('/filemanager/preview', 'FileManagerController@preview')->where('file', '.*');
        $router->post('/filemanager/move', 'FileManagerController@move');
        $router->post('/filemanager/rename', 'FileManagerController@rename')->where('file', '.*');
    });
