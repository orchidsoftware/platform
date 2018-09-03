<?php

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Users...
$this->screen('users/{users}/edit', 'User\UserEdit', 'platform.systems.users.edit');
$this->screen('users/create', 'User\UserEdit', 'platform.systems.users.create');
$this->screen('users', 'User\UserList', 'platform.systems.users');

// Roles...
$this->screen('roles/{roles}/edit', 'Role\RoleEdit', 'platform.systems.roles.edit');
$this->screen('roles/create', 'Role\RoleEdit', 'platform.systems.roles.create');
$this->screen('roles', 'Role\RoleList', 'platform.systems.roles');

// Example...
//Route::screen('/dashboard/screen/idea', 'Idea','platform.screens.idea');
