<?php

use Faker\Generator as Faker;
use Orchid\Platform\Core\Models\User as User;

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

$factory->define(User::class, function (Faker $faker) {
    static $password;

    $roles = [
        'admin' => [
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
        'user'  => [
            'dashboard.index'                => 1,
            'dashboard.systems'              => 1,
            'dashboard.systems.roles'        => 0,
            'dashboard.systems.settings'     => 1,
            'dashboard.systems.users'        => 0,
            'dashboard.systems.menu'         => 0,
            'dashboard.systems.category'     => 0,
            'dashboard.systems.comment'      => 1,
            'dashboard.systems.attachment'   => 1,
            'dashboard.systems.media'        => 1,
            'dashboard.pages'                => 0,
            'dashboard.pages.type.demo-page' => 0,
            'dashboard.posts'                => 0,
            'dashboard.posts.type.demo'      => 0,
        ],
        'autor' => [
            'dashboard.index'                => 1,
            'dashboard.systems'              => 1,
            'dashboard.systems.roles'        => 0,
            'dashboard.systems.settings'     => 1,
            'dashboard.systems.users'        => 0,
            'dashboard.systems.menu'         => 0,
            'dashboard.systems.category'     => 0,
            'dashboard.systems.comment'      => 1,
            'dashboard.systems.attachment'   => 1,
            'dashboard.systems.media'        => 1,
            'dashboard.pages'                => 1,
            'dashboard.pages.type.demo-page' => 1,
            'dashboard.posts'                => 1,
            'dashboard.posts.type.demo'      => 1,
        ],
    ];

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: bcrypt('secret'),
        'remember_token' => str_random(10),
        'last_login'     => $faker->dateTimeBetween('-6 days', 'this week'),
        'permissions'    => $roles['autor'],
    ];
});
