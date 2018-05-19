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
        'prefix'     => \Orchid\Platform\Dashboard::prefix('/systems'),
    ], function (\Illuminate\Routing\Router $router) {
        $router->screen('users/{users}/edit', config('platform.screens.users.edit'), 'platform.systems.users.edit');
        $router->screen('users/create', config('platform.screens.users.edit'), 'platform.systems.users.create');
        $router->screen('users', config('platform.screens.users.list'), 'platform.systems.users');
        $router->screen('roles/{roles}/edit', config('platform.screens.roles.edit'), 'platform.systems.roles.edit');
        $router->screen('roles/create', config('platform.screens.roles.edit'), 'platform.systems.roles.create');
        $router->screen('roles', config('platform.screens.roles.list'), 'platform.systems.roles');
    });

    $this->group([
        'middleware' => config('platform.middleware.private'),
        'prefix'     => \Orchid\Platform\Dashboard::prefix('/systems'),
        'namespace'  => 'Orchid\Platform\Http\Controllers\Systems',
    ], function (\Illuminate\Routing\Router $router) {
        $router->get('/', [
            'as'   => 'platform.systems.index',
            'uses' => 'SystemController@index',
        ]);

        $router->get('cache', [
            'as'   => 'platform.systems.cache',
            'uses' => 'CacheController@store',
        ]);

        $router->post('notification/read', [
            'as'   => 'platform.notification.read',
            'uses' => 'NotificationController@markAllAsRead',
        ]);

        $router->post('notification/remove', [
            'as'   => 'platform.notification.remove',
            'uses' => 'NotificationController@remove',
        ]);

        $router->post('files', [
            'as'   => 'platform.systems.files.upload',
            'uses' => 'AttachmentController@upload',
        ]);

        $router->post('files/sort', [
            'as'   => 'platform.systems.files.sort',
            'uses' => 'AttachmentController@sort',
        ]);

        $router->delete('files/{id}', [
            'as'   => 'platform.systems.files.destroy',
            'uses' => 'AttachmentController@destroy',
        ]);

        $router->get('files/post/{id}', [
            'as'   => 'platform.systems.files.destroy',
            'uses' => 'AttachmentController@getFilesPost',
        ]);

        $router->post('files/get', [
            'as'   => 'platform.systems.files.destroy',
            'uses' => 'AttachmentController@getFilesByIds',
        ]);

        $router->put('files/post/{id}', [
            'as'   => 'platform.systems.files.update',
            'uses' => 'AttachmentController@update',
        ]);

        $router->get('tags/{tags?}', [
            'as'   => 'platform.systems.tag.search',
            'uses' => 'TagsController@show',
        ]);

        $router->post('widget/{widget}/{key?}', [
            'as'   => 'platform.systems.widget',
            'uses' => 'WidgetController@index',
        ]);
    });
});
