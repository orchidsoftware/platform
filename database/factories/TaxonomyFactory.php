<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Orchid\Platform\Core\Models\Term;
use Orchid\Platform\Core\Models\Taxonomy;

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

$factory->define(Taxonomy::class, function (Faker $faker) {
    return [
        'taxonomy' => $faker->word,
        'parent_id' => 0,
        'term_id' => function () use ($faker) {
            return factory(Term::class)->create([
                'slug' => Str::slug($faker->word),
                'content' => [
                    'text' => $faker->text,
                ],
                'term_group' => 0,
            ])->term_id;
        },
    ];
});
