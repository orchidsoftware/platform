<?php

declare(strict_types=1);

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

// Platform
Breadcrumbs::for('platform.index', function (BreadcrumbsGenerator $trail) {
    $trail->push(__('Main'), route('platform.index'));
});

// Platform > System
Breadcrumbs::for('platform.systems.index', function (BreadcrumbsGenerator $trail) {
    $trail->parent('platform.index');
    $trail->push(__('Systems'), route('platform.systems.index'));
});

// Platform -> Notifications
Breadcrumbs::for('platform.notifications', function (BreadcrumbsGenerator $trail) {
    $trail->parent('platform.index');
    $trail->push(__('Notifications'));
});

// Platform -> Search Result
Breadcrumbs::for('platform.search', function (BreadcrumbsGenerator $trail, string $query) {
    $trail->parent('platform.index');
    $trail->push(__('Search'));
    $trail->push($query);
});
