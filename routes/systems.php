<?php

declare(strict_types=1);

use Orchid\Platform\Http\Controllers\Systems\SystemController;
use Orchid\Platform\Http\Controllers\Systems\RelationController;
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

$this->router->get('/', [SystemController::class, 'index'])
    ->name('systems.index');

$this->router->post('notification/read', [NotificationController::class, 'markAllAsRead'])
    ->name('notification.read');

$this->router->post('notification/remove', [NotificationController::class, 'remove'])
    ->name('notification.remove');

$this->router->post('files', [AttachmentController::class, 'upload'])
    ->name('systems.files.upload');

$this->router->post('media', [AttachmentController::class, 'media'])
    ->name('systems.files.media');

$this->router->post('files/sort', [AttachmentController::class, 'sort'])
    ->name('systems.files.sort');

$this->router->delete('files/{id}', [AttachmentController::class, 'destroy'])
    ->name('systems.files.destroy');

$this->router->post('files/get', [AttachmentController::class, 'getFilesByIds'])
    ->name('systems.files.getFilesByIds');

$this->router->put('files/post/{id}', [AttachmentController::class, 'update'])
    ->name('systems.files.update');

$this->router->post('relation', [RelationController::class, 'view'])
    ->name('systems.relation');
