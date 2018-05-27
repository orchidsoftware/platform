<?php

/*
|--------------------------------------------------------------------------
| Systems Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/


$this->screen('users/{users}/edit', config('platform.screens.users.edit'), 'platform.systems.users.edit');
$this->screen('users/create', config('platform.screens.users.edit'), 'platform.systems.users.create');
$this->screen('users', config('platform.screens.users.list'), 'platform.systems.users');
$this->screen('roles/{roles}/edit', config('platform.screens.roles.edit'), 'platform.systems.roles.edit');
$this->screen('roles/create', config('platform.screens.roles.edit'), 'platform.systems.roles.create');
$this->screen('roles', config('platform.screens.roles.list'), 'platform.systems.roles');


$this->get('/', [
    'as'   => 'platform.systems.index',
    'uses' => 'SystemController@index',
]);

$this->get('cache', [
    'as'   => 'platform.systems.cache',
    'uses' => 'CacheController@store',
]);

$this->post('notification/read', [
    'as'   => 'platform.notification.read',
    'uses' => 'NotificationController@markAllAsRead',
]);

$this->post('notification/remove', [
    'as'   => 'platform.notification.remove',
    'uses' => 'NotificationController@remove',
]);

$this->post('files', [
    'as'   => 'platform.systems.files.upload',
    'uses' => 'AttachmentController@upload',
]);

$this->post('files/sort', [
    'as'   => 'platform.systems.files.sort',
    'uses' => 'AttachmentController@sort',
]);

$this->delete('files/{id}', [
    'as'   => 'platform.systems.files.destroy',
    'uses' => 'AttachmentController@destroy',
]);

$this->get('files/post/{id}', [
    'as'   => 'platform.systems.files.destroy',
    'uses' => 'AttachmentController@getFilesPost',
]);

$this->post('files/get', [
    'as'   => 'platform.systems.files.destroy',
    'uses' => 'AttachmentController@getFilesByIds',
]);

$this->put('files/post/{id}', [
    'as'   => 'platform.systems.files.update',
    'uses' => 'AttachmentController@update',
]);

$this->get('tags/{tags?}', [
    'as'   => 'platform.systems.tag.search',
    'uses' => 'TagsController@show',
]);

$this->post('widget/{widget}/{key?}', [
    'as'   => 'platform.systems.widget',
    'uses' => 'WidgetController@index',
]);
