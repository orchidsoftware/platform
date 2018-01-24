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
        'namespace'  => 'Orchid\Platform\Http\Controllers\Systems',
    ], function (\Illuminate\Routing\Router $router) {
        $router->resource('users', 'UserController', [
            'names' => [
                'index'   => 'dashboard.systems.users',
                'create'  => 'dashboard.systems.users.create',
                'edit'    => 'dashboard.systems.users.edit',
                'update'  => 'dashboard.systems.users.update',
                'store'   => 'dashboard.systems.users.store',
                'destroy' => 'dashboard.systems.users.destroy',
            ],
        ]);

        $router->resource('roles', 'RoleController', [
            'names' => [
                'index'   => 'dashboard.systems.roles',
                'create'  => 'dashboard.systems.roles.create',
                'edit'    => 'dashboard.systems.roles.edit',
                'update'  => 'dashboard.systems.roles.update',
                'store'   => 'dashboard.systems.roles.store',
                'destroy' => 'dashboard.systems.roles.destroy',
            ],
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

        $router->put('files/post/{id}', [
            'as'   => 'dashboard.systems.files.update',
            'uses' => 'AttachmentController@update',
        ]);

        $router->resource('menu', 'MenuController', [
            'names' => [
                'index'  => 'dashboard.systems.menu.index',
                'show'   => 'dashboard.systems.menu.show',
                'update' => 'dashboard.systems.menu.update',
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

        $router->post('widget/{widget}/{key?}', [
            'as'   => 'dashboard.systems.widget',
            'uses' => 'WidgetController@index',
        ]);
    });
});
