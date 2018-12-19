<?php

use Faker\Generator as Faker;
use Orchid\Platform\Models\User as User;

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

$factory->define(User::class, function(Faker $faker) {
    static $password;

    $roles = [
        'admin' => [
            'platform.index'                => 1,
            'platform.systems'              => 1,
            'platform.systems.index'        => 1,
            'platform.systems.roles'        => 1,
            'platform.systems.settings'     => 1,
            'platform.systems.users'        => 1,
            'platform.systems.menu'         => 1,
            'platform.systems.category'     => 1,
            'platform.systems.comment'      => 1,
            'platform.systems.attachment'   => 1,
            'platform.systems.media'        => 1,
            'platform.systems.cache'        => 1,
            'platform.pages'                => 1,
            'platform.pages.type.demo-page' => 1,
            'platform.posts'                => 1,
            'platform.posts.type.demo'      => 1,
            'platform.posts.type.demo-page' => 1,
            'platform.bulldozer'            => 1,
            'platform.systems.backups'       => 1,
        ],
        'user'  => [
            'platform.index'                => 1,
            'platform.systems'              => 1,
            'platform.systems.roles'        => 0,
            'platform.systems.settings'     => 1,
            'platform.systems.users'        => 0,
            'platform.systems.menu'         => 0,
            'platform.systems.category'     => 0,
            'platform.systems.comment'      => 1,
            'platform.systems.attachment'   => 1,
            'platform.systems.media'        => 1,
            'platform.pages'                => 0,
            'platform.pages.type.demo-page' => 0,
            'platform.posts'                => 0,
            'platform.posts.type.demo'      => 0,
        ],
        'author' => [
            'platform.index'                => 1,
            'platform.systems'              => 1,
            'platform.systems.roles'        => 0,
            'platform.systems.settings'     => 1,
            'platform.systems.users'        => 0,
            'platform.systems.menu'         => 0,
            'platform.systems.category'     => 0,
            'platform.systems.comment'      => 1,
            'platform.systems.attachment'   => 1,
            'platform.systems.media'        => 1,
            'platform.pages'                => 1,
            'platform.pages.type.demo-page' => 1,
            'platform.posts'                => 1,
            'platform.posts.type.demo'      => 1,
        ],
    ];

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: bcrypt('secret'),
        'remember_token' => str_random(10),
        'last_login'     => $faker->dateTimeBetween('-6 days', 'this week'),
        'permissions'    => $roles['admin'],
    ];
});
