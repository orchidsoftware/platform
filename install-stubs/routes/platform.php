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

// Main
$this->screen('/main', 'PlatformScreen', 'platform.main');

// Users...
$this->screen('users/{users}/edit', 'User\UserEditScreen', 'platform.systems.users.edit');
$this->screen('users/create', 'User\UserEditScreen', 'platform.systems.users.create');
$this->screen('users', 'User\UserListScreen', 'platform.systems.users');

// Roles...
$this->screen('roles/{roles}/edit', 'Role\RoleEditScreen', 'platform.systems.roles.edit');
$this->screen('roles/create', 'Role\RoleEditScreen', 'platform.systems.roles.create');
$this->screen('roles', 'Role\RoleListScreen', 'platform.systems.roles');

// Comments...
$this->screen('comments/{comments}/edit', 'Comment\CommentEditScreen', 'platform.systems.comments.edit');
$this->screen('comments/create', 'Comment\CommentEditScreen', 'platform.systems.comments.create');
$this->screen('comments', 'Comment\CommentListScreen', 'platform.systems.comments');

// Categories...
$this->screen('category/{category}/edit', 'Category\CategoryEditScreen', 'platform.systems.category.edit');
$this->screen('category/create', 'Category\CategoryEditScreen', 'platform.systems.category.create');
$this->screen('category', 'Category\CategoryListScreen', 'platform.systems.category');

// Example...
//Route::screen('/dashboard/screen/idea', 'Idea','platform.screens.idea');
