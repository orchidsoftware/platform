<?php

use Orchid\Platform\Core\Models\Term;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(Term::class, function (Faker $faker) {
    return [
        'slug' => Str::slug($faker->word),
        'content' => [
            'text' => $faker->text
        ],
        'term_group' => 0,
    ];
});
