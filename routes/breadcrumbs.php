<?php

// Platform
Breadcrumbs::for('platform.index', function ($trail) {
    $trail->push('Platform', route('platform.index'));
});

// Platform > System
Breadcrumbs::for('platform.systems.index', function ($trail) {
    $trail->parent('platform.index');
    $trail->push('System', route('platform.systems.index'));
});

// Platform > System > Menu
Breadcrumbs::for('platform.systems.menu.index', function ($trail) {
    $trail->parent('platform.systems.index');
    $trail->push('Menu', route('platform.systems.menu.index'));
});

// Platform > System > Menu > Create
Breadcrumbs::for('platform.systems.menu.create ', function ($trail) {
    $trail->parent('platform.systems.menu.index');
    $trail->push('Create', route('platform.systems.menu.create '));
});

// Platform > System > Menu > Edit Menu
Breadcrumbs::for('platform.systems.menu.show', function ($trail, $menu) {
    $trail->parent('platform.systems.menu.index');
    $trail->push('Edit Menu', route('platform.systems.menu.show', $menu));
});

// Platform > System > Media
Breadcrumbs::for('platform.systems.media.index', function ($trail) {
    $trail->parent('platform.systems.index');
    $trail->push('Media', route('platform.systems.media.index'));
});

// Platform > Backup
Breadcrumbs::for('platform.savior.backups', function ($trail) {
    $trail->parent('platform.index');
    $trail->push('Backup', route('platform.savior.backups'));
});

// Platform > Bulldozer
Breadcrumbs::for('platform.bulldozer.index', function ($trail) {
    $trail->parent('platform.index');
    $trail->push('Bulldozer', route('platform.bulldozer.index'));
});

//Posts

// Platform > Posts

Breadcrumbs::for('platform.posts.type', function ($trail, $type) {
    $trail->parent('platform.index');
    $trail->push('Posts', route('platform.posts.type', $type->slug));
});

// Platform > Posts > Create

Breadcrumbs::for('platform.posts.type.create', function ($trail, $type) {
    $trail->parent('platform.posts.type', $type);
    $trail->push('Create', route('platform.posts.type.create', $type->slug));
});

// Platform > Posts > Edit
Breadcrumbs::for('platform.posts.type.edit', function ($trail, $type, $post) {
    $trail->parent('platform.posts.type', $type);
    $trail->push($post->getContent($type->slugFields), route('platform.posts.type.edit', [$type->slug, $post->slug]));
});

// Platform > Pages
Breadcrumbs::for('platform.pages.show', function ($trail, $page) {
    $trail->parent('platform.index');
    $trail->push('Pages', route('platform.pages.show', $page));
});
