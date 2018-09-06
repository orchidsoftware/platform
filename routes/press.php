<?php

/*
|--------------------------------------------------------------------------
| Press Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->post('posts/restore/{id?}', [
    'as'   => 'platform.posts.restore',
    'uses' => 'PostController@restore',
]);

$this->get('posts/{type}/create', [
    'as'   => 'platform.posts.type.create',
    'uses' => 'PostController@create',
]);

$this->get('posts/{type}/{post}/edit', [
    'as'   => 'platform.posts.type.edit',
    'uses' => 'PostController@edit',
]);

$this->get('posts/{type}/{post?}', [
    'as'   => 'platform.posts.type',
    'uses' => 'PostController@index',
]);

$this->post('posts/{type}', [
    'as'   => 'platform.posts.type.store',
    'uses' => 'PostController@store',
]);

$this->put('posts/{type}/{post?}', [
    'as'   => 'platform.posts.type.update',
    'uses' => 'PostController@update',
]);

$this->delete('posts/{type}/{post?}', [
    'as'   => 'platform.posts.type.destroy',
    'uses' => 'PostController@destroy',
]);

$this->resource('menu', 'MenuController', [
    'only'  => [
        'index', 'show', 'update', 'create', 'destroy',
    ],
    'names' => [
        'index'   => 'platform.systems.menu.index',
        'show'    => 'platform.systems.menu.show',
        'update'  => 'platform.systems.menu.update',
        'create'  => 'platform.systems.menu.create',
        'destroy' => 'platform.systems.menu.destroy',
    ],
]);

$this->get('page/{page}', [
    'as'   => 'platform.pages.show',
    'uses' => 'PageController@show',
]);

$this->put('page/{page}', [
    'as'   => 'platform.pages.update',
    'uses' => 'PageController@update',
]);

$this->group([
    'as'     => 'platform.systems.media.',
    'prefix' => 'media',
], function () {
    $this->get('/{parameters?}', ['uses' => 'MediaController@index', 'as' => 'index'])->where('parameters', '.*');
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
