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
    $jobTitle = $faker->jobTitle;

    return [
        'name'        => $jobTitle,
        'slug'        => str_slug($jobTitle),
        'permissions' => [],
    ];
});
