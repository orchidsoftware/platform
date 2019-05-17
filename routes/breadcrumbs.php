<?php

declare(strict_types=1);

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

// Platform
Breadcrumbs::for('platform.index', function ($trail) {
    $trail->push(__('Platform'), route('platform.index'));
});

// Platform > System
Breadcrumbs::for('platform.systems.index', function ($trail) {
    $trail->parent('platform.index');
    $trail->push(__('Systems'), route('platform.systems.index'));
});

// Platform > System > Announcement
Breadcrumbs::for('platform.systems.announcement', function ($trail) {
    $trail->parent('platform.systems.index');
    $trail->push(__('Announcement'), route('platform.systems.announcement'));
});
