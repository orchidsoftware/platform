<?php

declare(strict_types=1);

use Orchid\Press\Http\Screens\EntityEditScreen;
use Orchid\Press\Http\Screens\EntityListScreen;
use Orchid\Press\Http\Controllers\MenuController;

/*
|--------------------------------------------------------------------------
| Press Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->screen('entities/{type}/{post?}/edit', EntityEditScreen::class)->name('entities.type.edit');
$this->screen('entities/{type}/create', EntityEditScreen::class)->name('entities.type.create');
$this->screen('entities/{type}/{page?}/page', EntityEditScreen::class)->name('entities.type.page');
$this->screen('entities/{type}', EntityListScreen::class)->name('entities.type');

$this->resource('menu', MenuController::class, [
    'only'  => [
        'index', 'show', 'update', 'create', 'destroy',
    ],
    'names' => [
        'index'   => 'systems.menu.index',
        'show'    => 'systems.menu.show',
        'update'  => 'systems.menu.update',
        'create'  => 'systems.menu.create',
        'destroy' => 'systems.menu.destroy',
    ],
]);
