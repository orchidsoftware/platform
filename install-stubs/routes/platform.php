<?php

use App\Orchid\Screens\ExampleScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\Comment\CommentEditScreen;
use App\Orchid\Screens\Comment\CommentListScreen;
use App\Orchid\Screens\Category\CategoryEditScreen;
use App\Orchid\Screens\Category\CategoryListScreen;

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
$this->screen('/main', PlatformScreen::class)->name('platform.main');

// Users...
$this->screen('users/{users}/edit', UserEditScreen::class)->name('platform.systems.users.edit');
$this->screen('users', UserListScreen::class)->name('platform.systems.users');

// Roles...
$this->screen('roles/{roles}/edit', RoleEditScreen::class)->name('platform.systems.roles.edit');
$this->screen('roles/create', RoleEditScreen::class)->name('platform.systems.roles.create');
$this->screen('roles', RoleListScreen::class)->name('platform.systems.roles');

// Comments...
$this->screen('comments/{comments}/edit', CommentEditScreen::class)->name('platform.systems.comments.edit');
$this->screen('comments/create', CommentEditScreen::class)->name('platform.systems.comments.create');
$this->screen('comments', CommentListScreen::class)->name('platform.systems.comments');

// Categories...
$this->screen('category/{category}/edit', CategoryEditScreen::class)->name('platform.systems.category.edit');
$this->screen('category/create', CategoryEditScreen::class)->name('platform.systems.category.create');
$this->screen('category', CategoryListScreen::class)->name('platform.systems.category');

// Example...
$this->screen('example', ExampleScreen::class)->name('platform.example');
//Route::screen('/dashboard/screen/idea', 'Idea::class','platform.screens.idea');
