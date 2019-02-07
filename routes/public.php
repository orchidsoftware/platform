<?php

declare(strict_types=1);

use Orchid\Platform\Http\Controllers\Systems\ResourceController;

$this->get('/orchid/{package}/{patch}',[ResourceController::class, 'show'])
    ->where('patch', '.*')
    ->name('platform.resource');