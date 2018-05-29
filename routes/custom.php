<?php

$this->screen('users/{users}/edit', config('platform.screens.users.edit'), 'platform.systems.users.edit');
$this->screen('users/create', config('platform.screens.users.edit'), 'platform.systems.users.create');
$this->screen('users', config('platform.screens.users.list'), 'platform.systems.users');
$this->screen('roles/{roles}/edit', config('platform.screens.roles.edit'), 'platform.systems.roles.edit');
$this->screen('roles/create', config('platform.screens.roles.edit'), 'platform.systems.roles.create');
$this->screen('roles', config('platform.screens.roles.list'), 'platform.systems.roles');