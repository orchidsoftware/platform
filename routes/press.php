<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Press Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

use Orchid\Press\Http\Controllers\MediaController;
use Orchid\Press\Http\Controllers\MenuController;
use Orchid\Press\Http\Controllers\PageController;
use Orchid\Press\Http\Controllers\PostController;

$this->post('posts/restore/{id?}', [PostController::class, 'restore'])
    ->name('platform.posts.restore');

$this->get('posts/{type}/create', [PostController::class, 'create'])
    ->name('platform.posts.type.create');

$this->get('posts/{type}/{post}/edit', [PostController::class, 'edit'])
    ->name('platform.posts.type.edit');

$this->get('posts/{type}/{post?}', [PostController::class, 'index'])
    ->name('platform.posts.type');

$this->post('posts/{type}', [PostController::class, 'store'])
    ->name('platform.posts.type.store');

$this->put('posts/{type}/{post?}', [PostController::class, 'update'])
    ->name('platform.posts.type.update');

$this->delete('posts/{type}/{post?}', [PostController::class, 'destroy'])
    ->name('platform.posts.type.destroy');


$this->resource('menu', MenuController::class, [
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

$this->get('page/{page}', [PageController::class, 'show'])
    ->name('platform.pages.show');

$this->put('page/{page}', [PageController::class, 'update'])
    ->name('platform.pages.update');

$this->group([
    'as'     => 'platform.systems.media.',
    'prefix' => 'media',
], function () {
    $this->get('/{parameters?}', ['uses' => MediaController::class . '@index', 'as' => 'index'])->where('parameters', '.*');
    $this->post('files', ['uses' => MediaController::class . '@files', 'as' => 'files']);
    $this->post('new_folder', ['uses' => MediaController::class . '@newFolder', 'as' => 'newFolder']);
    $this->post('delete_file_folder', ['uses' => MediaController::class . '@deleteFileFolder', 'as' => 'deleteFileFolder']);
    $this->post('directories', ['uses' => MediaController::class . '@getAllDirs', 'as' => 'getAllDirs']);
    $this->post('move_file', ['uses' => MediaController::class . '@moveFile', 'as' => 'moveFile']);
    $this->post('rename_file', ['uses' => MediaController::class . '@renameFile', 'as' => 'renameFile']);
    $this->post('upload', ['uses' => MediaController::class . '@upload', 'as' => 'upload']);
    $this->post('remove', ['uses' => MediaController::class . '@remove', 'as' => 'remove']);
});
