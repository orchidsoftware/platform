<?php

use Faker\Generator as Faker;
use Orchid\Platform\Models\Role;

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
            'platform.index'              => 1,
            'platform.systems'            => 1,
            'platform.systems.roles'      => 1,
            'platform.systems.settings'   => 1,
            'platform.systems.users'      => 1,
            'platform.systems.menu'       => 1,
            'platform.systems.category'   => 1,
            'platform.systems.comment'    => 1,
            'platform.systems.attachment' => 1,
            'platform.systems.media'      => 1,
            'platform.pages'              => 1,
            'platform.posts'              => 1,
        ],
        $role[1] => [
            'platform.index'              => 1,
            'platform.systems'            => 1,
            'platform.systems.settings'   => 1,
            'platform.systems.comment'    => 1,
            'platform.systems.attachment' => 1,
            'platform.systems.media'      => 1,
        ],
        $role[2] => [
            'platform.index'              => 1,
            'platform.systems'            => 1,
            'platform.systems.settings'   => 1,
            'platform.systems.comment'    => 1,
            'platform.systems.attachment' => 1,
            'platform.systems.media'      => 1,
            'platform.pages'              => 1,
            'platform.posts'              => 1,
        ],
    ];

    $selRole = $faker->randomElement($role);

    return [
        'name'        => $faker->lexify($selRole . '_???'),
        'slug'        => $faker->unique()->jobTitle,
        'permissions' => $roles[$selRole],
    ];
});
