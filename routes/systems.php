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
        $router->screen('users/{users}/edit', config('platform.screens.users.edit'), 'dashboard.systems.users.edit');
        $router->screen('users/create', config('platform.screens.users.edit'), 'dashboard.systems.users.create');
        $router->screen('users', config('platform.screens.users.list'), 'dashboard.systems.users');
        $router->screen('roles/{roles}/edit', config('platform.screens.roles.edit'), 'dashboard.systems.roles.edit');
        $router->screen('roles/create', config('platform.screens.roles.edit'), 'dashboard.systems.roles.create');
        $router->screen('roles', config('platform.screens.roles.list'), 'dashboard.systems.roles');
    });

    $this->group([
        'middleware' => config('platform.middleware.private'),
        'prefix'     => \Orchid\Platform\Dashboard::prefix('/systems'),
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

        $router->get('tags/{tags?}', [
            'as'   => 'dashboard.systems.tag.search',
            'uses' => 'TagsController@show',
        ]);

        $router->post('widget/{widget}/{key?}', [
            'as'   => 'dashboard.systems.widget',
            'uses' => 'WidgetController@index',
        ]);
    });
});
