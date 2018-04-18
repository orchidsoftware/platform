<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\App;
use Orchid\Platform\Core\Models\Menu;

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

$factory->define(Menu::class, function (Faker $faker) {
    $lang = App::getLocale();
    $MenuTitle = $faker->unique()->word;

    $RobotArr = ['answer', 'chapter', 'co-worker', 'colleague', 'contact',
        'details', 'edit', 'friend', 'question', 'archives', 'author',
        'bookmark', 'first', 'help', 'index', 'last', 'license', 'me',
        'next', 'nofollow', 'noreferrer', 'prefetch', 'prev', 'search',
        'sidebar', 'tag', 'up', ];

    return [
        'label'  => Str::slug($MenuTitle),
        'title'  => $MenuTitle.' '.Str::slug($faker->word),
        'slug'   => '/'.Str::slug($MenuTitle),
        'robot'  => $faker->randomElement($RobotArr),
        'style'  => $faker->safeColorName,
        'target' => $faker->randomElement(['_self', '_blank']),
        'auth'   => $faker->randomElement([0, 1]),
        'lang'   => $lang,
        'sort'   => 0,
    ];
});
