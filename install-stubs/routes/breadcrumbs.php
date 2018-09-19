<?php

//Screens

// Platform > Users
Breadcrumbs::for('platform.systems.users', function ($trail) {
    $trail->parent('platform.index');
    $trail->push('Users', route('platform.systems.users'));
});

// Platform > Users > Ceate
Breadcrumbs::for('platform.systems.users.create', function ($trail) {
    $trail->parent('platform.systems.users');
    $trail->push('Create', route('platform.systems.users.create'));
});

// Platform > Users > User
Breadcrumbs::for('platform.systems.users.edit', function ($trail, $user) {
    $trail->parent('platform.systems.users');
    $trail->push('Edit', route('platform.systems.users.edit', $user));
});

// Platform > Roles
Breadcrumbs::for('platform.systems.roles', function ($trail) {
    $trail->parent('platform.index');
    $trail->push('Roles', route('platform.systems.roles'));
});

// Platform > Roles > Create
Breadcrumbs::for('platform.systems.roles.create', function ($trail) {
    $trail->parent('platform.systems.roles');
    $trail->push('Create', route('platform.systems.roles.create'));
});

// Platform > Roles > Role
Breadcrumbs::for('platform.systems.roles.edit', function ($trail, $role) {
    $trail->parent('platform.systems.roles');
    $trail->push('Role', route('platform.systems.roles.edit', $role));
});

// Platform > Category
Breadcrumbs::for('platform.systems.category', function ($trail) {
    $trail->parent('platform.index');
    $trail->push('Categories', route('platform.systems.category'));
});

// Platform > Categories > Create
Breadcrumbs::for('platform.systems.category.create', function ($trail) {
    $trail->parent('platform.systems.category');
    $trail->push('Create', route('platform.systems.category.create'));
});

// Platform > Categories > Category
Breadcrumbs::for('platform.systems.category.edit', function ($trail, $category) {
    $trail->parent('platform.systems.category');
    $trail->push('Category', route('platform.systems.category.edit', $category));
});

// Platform > Comments
Breadcrumbs::for('platform.systems.comments', function ($trail) {
    $trail->parent('platform.index');
    $trail->push('Comments', route('platform.systems.comments'));
});

// Platform > Comments > Create
Breadcrumbs::for('platform.systems.comments.create', function ($trail) {
    $trail->parent('platform.systems.comments');
    $trail->push('Create', route('platform.systems.comments.create'));
});

// Platform > Comments > Comment
Breadcrumbs::for('platform.systems.comments.edit', function ($trail, $comment) {
    $trail->parent('platform.systems.comments');
    $trail->push('Comment', route('platform.systems.comments.edit', $comment));
});
