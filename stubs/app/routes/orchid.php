<?php

declare(strict_types=1);

use App\Orchid\Screens\Examples\ExampleActionsScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleGridScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

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
Route::screen('/main', PlatformScreen::class)
    ->name('orchid.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('orchid.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('orchid.index')
        ->push(__('Profile'), route('orchid.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('orchid.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('orchid.systems.users')
        ->push($user->name, route('orchid.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('orchid.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('orchid.systems.users')
        ->push(__('Create'), route('orchid.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('orchid.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('orchid.index')
        ->push(__('Users'), route('orchid.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('orchid.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('orchid.systems.roles')
        ->push($role->name, route('orchid.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('orchid.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('orchid.systems.roles')
        ->push(__('Create'), route('orchid.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('orchid.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('orchid.index')
        ->push(__('Roles'), route('orchid.systems.roles')));

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('orchid.example')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('orchid.index')
        ->push('Example Screen'));

Route::screen('/examples/form/fields', ExampleFieldsScreen::class)->name('orchid.example.fields');
Route::screen('/examples/form/advanced', ExampleFieldsAdvancedScreen::class)->name('orchid.example.advanced');
Route::screen('/examples/form/editors', ExampleTextEditorsScreen::class)->name('orchid.example.editors');
Route::screen('/examples/form/actions', ExampleActionsScreen::class)->name('orchid.example.actions');

Route::screen('/examples/layouts', ExampleLayoutsScreen::class)->name('orchid.example.layouts');
Route::screen('/examples/grid', ExampleGridScreen::class)->name('orchid.example.grid');
Route::screen('/examples/charts', ExampleChartsScreen::class)->name('orchid.example.charts');
Route::screen('/examples/cards', ExampleCardsScreen::class)->name('orchid.example.cards');

// Route::screen('idea', Idea::class, 'orchid.screens.idea');
