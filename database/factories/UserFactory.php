<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;
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

$factory->define(User::class, function (Faker $faker) {
    static $password;

    $roles = [
        'admin'  => [
            'platform.index'                      => 1,
            'platform.systems'                    => 1,
            'platform.systems.index'              => 1,
            'platform.systems.roles'              => 1,
            'platform.systems.settings'           => 1,
            'platform.systems.users'              => 1,
            'platform.systems.menu'               => 1,
            'platform.systems.category'           => 1,
            'platform.systems.comment'            => 1,
            'platform.systems.attachment'         => 1,
            'platform.systems.media'              => 1,
            'platform.pages'                      => 1,
            'platform.posts'                      => 1,
            'platform.entities.type.example-post' => 1,
            'platform.entities.type.example-page' => 1,
            'platform.bulldozer'                  => 1,
        ],
        'user'   => [
            'platform.index'                       => 1,
            'platform.systems'                     => 1,
            'platform.systems.roles'               => 0,
            'platform.systems.settings'            => 1,
            'platform.systems.users'               => 0,
            'platform.systems.menu'                => 0,
            'platform.systems.category'            => 0,
            'platform.systems.comment'             => 1,
            'platform.systems.attachment'          => 1,
            'platform.systems.media'               => 1,
            'platform.pages'                       => 0,
            'platform.entities.type..example-page' => 0,
            'platform.posts'                       => 0,
            'platform.entities.type..example-post' => 0,
        ],
        'author' => [
            'platform.index'                      => 1,
            'platform.systems'                    => 1,
            'platform.systems.roles'              => 0,
            'platform.systems.settings'           => 1,
            'platform.systems.users'              => 0,
            'platform.systems.menu'               => 0,
            'platform.systems.category'           => 0,
            'platform.systems.comment'            => 1,
            'platform.systems.attachment'         => 1,
            'platform.systems.media'              => 1,
            'platform.pages'                      => 1,
            'platform.entities.type.example-page' => 1,
            'platform.entities.type.example-post' => 1,
        ],
    ];

    return [
        'name'           => $faker->firstName,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: bcrypt('secret'),
        'remember_token' => Str::random(10),
        'last_login'     => $faker->dateTimeBetween('-6 days', 'this week'),
        'permissions'    => $roles['admin'],
    ];
});
