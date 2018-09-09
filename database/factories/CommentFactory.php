<?php

use Faker\Generator as Faker;
use Orchid\Press\Models\Comment;

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

$factory->define(Comment::class, function (Faker $faker) {

    return [
        'content'   => $faker->paragraph(2,true),
        'approved'  => $faker->randomElement([0, 1]),
    ];
});
