<?php

declare(strict_types=1);

use Orchid\Platform\Http\Controllers\Systems\TagsController;
use Orchid\Platform\Http\Controllers\Systems\CacheController;
use Orchid\Platform\Http\Controllers\Systems\SystemController;
use Orchid\Platform\Http\Controllers\Systems\WidgetController;
use Orchid\Platform\Http\Controllers\Systems\AttachmentController;
use Orchid\Platform\Http\Controllers\Systems\NotificationController;

/*
|--------------------------------------------------------------------------
| Systems Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->get('/', [SystemController::class, 'index'])
    ->name('systems.index');

$this->get('cache', [CacheController::class, 'store'])
    ->name('systems.cache');

$this->post('notification/read', [NotificationController::class, 'markAllAsRead'])
    ->name('notification.read');

$this->post('notification/remove', [NotificationController::class, 'remove'])
    ->name('notification.remove');

$this->post('files', [AttachmentController::class, 'upload'])
    ->name('systems.files.upload');

$this->post('files/sort', [AttachmentController::class, 'sort'])
    ->name('systems.files.sort');

$this->delete('files/{id}', [AttachmentController::class, 'destroy'])
    ->name('systems.files.destroy');

$this->post('files/get', [AttachmentController::class, 'getFilesByIds'])
    ->name('systems.files.getFilesByIds');

$this->put('files/post/{id}', [AttachmentController::class, 'update'])
    ->name('systems.files.update');

$this->get('tags/{tags?}', [TagsController::class, 'show'])
    ->name('systems.tag.search');

$this->post('widget/{widget}/{key?}', [WidgetController::class, 'index'])
    ->name('systems.widget');
