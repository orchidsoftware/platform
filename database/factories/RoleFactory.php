<?php

use Faker\Generator as Faker;
use Orchid\Platform\Core\Models\Role;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Role::class, function (Faker $faker) {
    $role = ['Admin', 'User', 'Autor'];
    $roles = [
        $role[0] => [
            'dashboard.index'                => 1,
            'dashboard.systems'              => 1,
            'dashboard.systems.roles'        => 1,
            'dashboard.systems.settings'     => 1,
            'dashboard.systems.users'        => 1,
            'dashboard.systems.menu'         => 1,
            'dashboard.systems.category'     => 1,
            'dashboard.systems.comment'      => 1,
            'dashboard.systems.attachment'   => 1,
            'dashboard.systems.media'        => 1,
            'dashboard.pages'                => 1,
            'dashboard.pages.type.demo-page' => 1,
            'dashboard.posts'                => 1,
            'dashboard.posts.type.demo'      => 1,
        ],
        $role[1] => [
            'dashboard.index'              => 1,
            'dashboard.systems'            => 1,
            'dashboard.systems.settings'   => 1,
            'dashboard.systems.comment'    => 1,
            'dashboard.systems.attachment' => 1,
            'dashboard.systems.media'      => 1,
        ],
        $role[2] => [
            'dashboard.index'                => 1,
            'dashboard.systems'              => 1,
            'dashboard.systems.settings'     => 1,
            'dashboard.systems.comment'      => 1,
            'dashboard.systems.attachment'   => 1,
            'dashboard.systems.media'        => 1,
            'dashboard.pages'                => 1,
            'dashboard.pages.type.demo-page' => 1,
            'dashboard.posts'                => 1,
            'dashboard.posts.type.demo'      => 1,
        ],
    ];
    $selRole = $faker->randomElement($role);
    $Title = $faker->lexify($selRole.'_???');
    //$jobTitle = $faker->jobTitle;

    return [
        'name'        => $Title,
        'slug'        => str_slug($Title),
        'permissions' => $roles[$selRole],
    ];
});
