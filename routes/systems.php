<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Systems Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

use Orchid\Platform\Http\Controllers\Systems\TagsController;
use Orchid\Platform\Http\Controllers\Systems\CacheController;
use Orchid\Platform\Http\Controllers\Systems\SystemController;
use Orchid\Platform\Http\Controllers\Systems\WidgetController;
use Orchid\Platform\Http\Controllers\Systems\SupportController;
use Orchid\Platform\Http\Controllers\Systems\AttachmentController;
use Orchid\Platform\Http\Controllers\Systems\NotificationController;

$this->get('/', [SystemController::class, 'index'])
    ->name('platform.systems.index');

$this->get('cache', [CacheController::class, 'store'])
    ->name('platform.systems.cache');

$this->post('notification/read', [NotificationController::class, 'markAllAsRead'])
    ->name('platform.notification.read');

$this->post('notification/remove', [NotificationController::class, 'remove'])
    ->name('platform.notification.remove');

$this->post('files', [AttachmentController::class, 'upload'])
    ->name('platform.systems.files.upload');

$this->post('files/sort', [AttachmentController::class, 'sort'])
    ->name('platform.systems.files.sort');

$this->delete('files/{id}', [AttachmentController::class, 'destroy'])
    ->name('platform.systems.files.destroy');

$this->get('files/post/{id}', [AttachmentController::class, 'getFilesPost'])
    ->name('platform.systems.files.getFilesPost');

$this->post('files/get', [AttachmentController::class, 'getFilesByIds'])
    ->name('platform.systems.files.getFilesByIds');

$this->put('files/post/{id}', [AttachmentController::class, 'update'])
    ->name('platform.systems.files.update');

$this->get('tags/{tags?}', [TagsController::class, 'show'])
    ->name('platform.systems.tag.search');

$this->post('widget/{widget}/{key?}', [WidgetController::class, 'index'])
    ->name('platform.systems.widget');

$this->post('support', [SupportController::class, 'send'])
    ->name('platform.systems.support');
