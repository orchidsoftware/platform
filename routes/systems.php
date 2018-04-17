<?php

/*
|--------------------------------------------------------------------------
| Systems Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->domain(config('platform.domain'))->group(function () {


    $this->group([
        'middleware' => config('platform.middleware.private'),
        'prefix'     => \Orchid\Platform\Kernel\Dashboard::prefix('/systems'),
    ], function (\Illuminate\Routing\Router $router) {

        $router->screen('users/{users}/edit', config('platform.screens.users.edit'), 'dashboard.systems.users.edit');
        $router->screen('users/create', config('platform.screens.users.edit'), 'dashboard.systems.users.create');
        $router->screen('users', config('platform.screens.users.list'), 'dashboard.systems.users');
        $router->screen('roles/{roles}/edit', config('platform.screens.roles.edit'), 'dashboard.systems.roles.edit');
        $router->screen('roles/create', config('platform.screens.roles.edit'), 'dashboard.systems.roles.create');
        $router->screen('roles', config('platform.screens.roles.list'), 'dashboard.systems.roles');

    });

    $this->group([
        'middleware' => config('platform.middleware.private'),
        'prefix'     => \Orchid\Platform\Kernel\Dashboard::prefix('/systems'),
        'namespace'  => 'Orchid\Platform\Http\Controllers\Systems',
    ], function (\Illuminate\Routing\Router $router) {


        $router->get('/', [
            'as'   => 'dashboard.systems.index',
            'uses' => 'SystemController@index',
        ]);

        $router->get('cache', [
            'as'   => 'dashboard.systems.cache',
            'uses' => 'CacheController@index',
        ]);

        $router->post('cache', [
            'as'   => 'dashboard.systems.cache',
            'uses' => 'CacheController@store',
        ]);

        $router->post('notification/read', [
            'as'   => 'dashboard.notification.read',
            'uses' => 'NotificationController@markAllAsRead',
        ]);

        $router->post('notification/remove', [
            'as'   => 'dashboard.notification.remove',
            'uses' => 'NotificationController@remove',
        ]);

        $router->get('settings', [
            'as'   => 'dashboard.systems.settings',
            'uses' => 'SettingController@index',
        ]);

        $router->post('settings', [
            'as'   => 'dashboard.systems.settings',
            'uses' => 'SettingController@store',
        ]);

        $router->resource('category', 'CategoryController', [
            'only'  => [
                'index', 'create', 'edit', 'update', 'store', 'destroy',
            ],
            'names' => [
                'index'   => 'dashboard.systems.category',
                'create'  => 'dashboard.systems.category.create',
                'edit'    => 'dashboard.systems.category.edit',
                'update'  => 'dashboard.systems.category.update',
                'store'   => 'dashboard.systems.category.store',
                'destroy' => 'dashboard.systems.category.destroy',
            ],
        ]);
        
        $router->resource('comment', 'CommentController', [
            'only'  => [
                'index', 'create', 'edit', 'update', 'store', 'destroy',
            ],
            'names' => [
                'index'   => 'dashboard.systems.comment',
                'create'  => 'dashboard.systems.comment.create',
                'edit'    => 'dashboard.systems.comment.edit',
                'update'  => 'dashboard.systems.comment.update',
                'store'   => 'dashboard.systems.comment.store',
                'destroy' => 'dashboard.systems.comment.destroy',
            ],
        ]);

        $router->post('files', [
            'as'   => 'dashboard.systems.files.upload',
            'uses' => 'AttachmentController@upload',
        ]);

        $router->post('files/sort', [
            'as'   => 'dashboard.systems.files.sort',
            'uses' => 'AttachmentController@sort',
        ]);

        $router->delete('files/{id}', [
            'as'   => 'dashboard.systems.files.destroy',
            'uses' => 'AttachmentController@destroy',
        ]);

        $router->get('files/post/{id}', [
            'as'   => 'dashboard.systems.files.destroy',
            'uses' => 'AttachmentController@getFilesPost',
        ]);

        $router->post('files/get', [
            'as'   => 'dashboard.systems.files.destroy',
            'uses' => 'AttachmentController@getFilesByIds',
        ]);

        $router->put('files/post/{id}', [
            'as'   => 'dashboard.systems.files.update',
            'uses' => 'AttachmentController@update',
        ]);

        $router->resource('menu', 'MenuController', [
            'only'  => [
                'index', 'show', 'update', 'destroy',
            ],
            'names' => [
                'index'   => 'dashboard.systems.menu.index',
                'show'    => 'dashboard.systems.menu.show',
                'update'  => 'dashboard.systems.menu.update',
                'destroy' => 'dashboard.systems.menu.destroy',
            ],
        ]);

        $router->get('tags/{tags?}', [
            'as'   => 'dashboard.systems.tag.search',
            'uses' => 'TagsController@show',
        ]);

        $router->group([
            'as'     => 'dashboard.systems.media.',
            'prefix' => 'media',
        ], function () {
            $this->get('/', ['uses' => 'MediaController@index', 'as' => 'index']);
            $this->post('files', ['uses' => 'MediaController@files', 'as' => 'files']);
            $this->post('new_folder', ['uses' => 'MediaController@newFolder', 'as' => 'newFolder']);
            $this->post('delete_file_folder',
                ['uses' => 'MediaController@deleteFileFolder', 'as' => 'deleteFileFolder']);
            $this->post('directories', ['uses' => 'MediaController@getAllDirs', 'as' => 'getAllDirs']);
            $this->post('move_file', ['uses' => 'MediaController@moveFile', 'as' => 'moveFile']);
            $this->post('rename_file', ['uses' => 'MediaController@renameFile', 'as' => 'renameFile']);
            $this->post('upload', ['uses' => 'MediaController@upload', 'as' => 'upload']);
            $this->post('remove', ['uses' => 'MediaController@remove', 'as' => 'remove']);
        });

        $router->group([
            'as'     => 'dashboard.systems.media2.',
            'prefix' => 'media2',
        ], function () {
            $this->get('/', ['uses' => 'Media2Controller@index', 'as' => 'index']);
            $this->post('files', ['uses' => 'Media2Controller@files', 'as' => 'files']);
            $this->post('new_folder', ['uses' => 'Media2Controller@newFolder', 'as' => 'newFolder']);
            $this->post('delete_file_folder',
                ['uses' => 'Media2Controller@deleteFileFolder', 'as' => 'deleteFileFolder']);
            $this->post('directories', ['uses' => 'Media2Controller@getAllDirs', 'as' => 'getAllDirs']);
            $this->post('move_file', ['uses' => 'Media2Controller@moveFile', 'as' => 'moveFile']);
            $this->post('rename_file', ['uses' => 'Media2Controller@renameFile', 'as' => 'renameFile']);
            $this->post('upload', ['uses' => 'Media2Controller@upload', 'as' => 'upload']);
            $this->post('remove', ['uses' => 'Media2Controller@remove', 'as' => 'remove']);
        });
        

        $router->post('widget/{widget}/{key?}', [
            'as'   => 'dashboard.systems.widget',
            'uses' => 'WidgetController@index',
        ]);
    });
});
