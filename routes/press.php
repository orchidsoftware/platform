<?php

declare(strict_types=1);

use Orchid\Press\Http\Controllers\MenuController;
use Orchid\Press\Http\Controllers\MediaController;
use Orchid\Press\Http\Screens\EntityEditScreen;
use Orchid\Press\Http\Screens\EntityListScreen;

/*
|--------------------------------------------------------------------------
| Press Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->screen('entities/{type}', EntityListScreen::class)
    ->name('platform.entities.type');

$this->screen('entity/{type}/{post?}', EntityEditScreen::class)
    ->name('platform.entities.type.edit');

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

$this->group([
    'as'     => 'platform.systems.media.',
    'prefix' => 'media',
], function () {
    $this->get('/{parameters?}', ['uses' => MediaController::class.'@index', 'as' => 'index'])->where('parameters', '.*');
    $this->post('files', ['uses' => MediaController::class.'@files', 'as' => 'files']);
    $this->post('new_folder', ['uses' => MediaController::class.'@newFolder', 'as' => 'newFolder']);
    $this->post('delete_file_folder', ['uses' => MediaController::class.'@deleteFileFolder', 'as' => 'deleteFileFolder']);
    $this->post('directories', ['uses' => MediaController::class.'@getAllDirs', 'as' => 'getAllDirs']);
    $this->post('move_file', ['uses' => MediaController::class.'@moveFile', 'as' => 'moveFile']);
    $this->post('rename_file', ['uses' => MediaController::class.'@renameFile', 'as' => 'renameFile']);
    $this->post('upload', ['uses' => MediaController::class.'@upload', 'as' => 'upload']);
    $this->post('remove', ['uses' => MediaController::class.'@remove', 'as' => 'remove']);
});
