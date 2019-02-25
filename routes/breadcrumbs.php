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

// Platform > System > Menu
Breadcrumbs::for('platform.systems.menu.index', function ($trail) {
    $trail->parent('platform.systems.index');
    $trail->push(__('Menu'), route('platform.systems.menu.index'));
});

// Platform > System > Menu > Create
Breadcrumbs::for('platform.systems.menu.create ', function ($trail) {
    $trail->parent('platform.systems.menu.index');
    $trail->push(__('Create'), route('platform.systems.menu.create '));
});

// Platform > System > Menu > Editing
Breadcrumbs::for('platform.systems.menu.show', function ($trail, $menu) {
    $trail->parent('platform.systems.menu.index');
    $trail->push(__('Editing'), route('platform.systems.menu.show', $menu));
});

// Platform > System > Announcement
Breadcrumbs::for('platform.systems.announcement', function ($trail) {
    $trail->parent('platform.systems.index');
    $trail->push(__('Announcement'), route('platform.systems.announcement'));
});

//Posts

// Platform > Posts
Breadcrumbs::for('platform.entities.type', function ($trail, $type) {
    $trail->parent('platform.index');
    $trail->push(__('Posts'), route('platform.entities.type', $type->slug));
});

// Platform > Posts > Create
Breadcrumbs::for('platform.entities.type.create', function ($trail, $type) {
    $trail->parent('platform.entities.type', $type);
    $trail->push(__('Create'), route('platform.entities.type', $type->slug));
});

// Platform > Posts > Edit
Breadcrumbs::for('platform.entities.type.edit', function ($trail, $type, $post) {
    $trail->parent('platform.entities.type', $type);
    $trail->push($post->getContent($type->slugFields) ?? '—', route('platform.entities.type.edit', [$type->slug, $post->slug]));
});

// Platform > Pages
Breadcrumbs::for('platform.entities.type.page', function ($trail, $page) {
    $trail->parent('platform.index');
    $trail->push(__('Pages'), route('platform.entities.type.page', $page));
});
