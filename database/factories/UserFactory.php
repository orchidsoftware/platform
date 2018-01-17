<?php

use Faker\Generator as Faker;
use Orchid\Platform\Core\Models\User;

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

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: bcrypt('secret'),
        'remember_token' => str_random(10),
        'last_login' => $faker->dateTimeBetween('-6 days', 'this week'),
        'permissions' => [],
    ];
});
