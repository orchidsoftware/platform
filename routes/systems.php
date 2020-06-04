<?php

declare(strict_types=1);

use Orchid\Platform\Http\Controllers\Systems\AttachmentController;
use Orchid\Platform\Http\Controllers\Systems\RelationController;
use Orchid\Platform\Http\Controllers\Systems\SystemController;
use Tabuna\Breadcrumbs\Trail;

$this->router->get('/', [SystemController::class, 'index'])
    ->name('systems.index')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Systems'), route('platform.systems.index'));
    });

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
