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

// Platform -> Notifications
Breadcrumbs::for('platform.notifications', function ($trail) {
    $trail->parent('platform.index');
    $trail->push(__('Notifications'));
});

// Platform -> Search Result
Breadcrumbs::for('platform.search', function ($trail, $query) {
    $trail->parent('platform.index');
    $trail->push(__('Search'));
    $trail->push($query);
});
