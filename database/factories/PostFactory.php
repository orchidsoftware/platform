<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\App;
use Orchid\Platform\Core\Models\Post;
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

$factory->define(Post::class, function (Faker $faker) {
    $lang = App::getLocale();

    $user = User::inRandomOrder()->first()->id;

    //$type		= 	 $faker->randomElement(["page","demo"]);
    $type = $faker->randomElement(['demo']);

    $status = ['publish'];

    $name = $faker->sentence($nbWords = 6, $variableNbWords = true);

    $post = [
        'user_id' => $user,
        'type'    => $type,
        'status'  => $faker->randomElement($status),
        'content' => [
            $lang => [
                'name'        => $name,
                'title'       => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'description' => $faker->paragraph($nbSentences = 2, $variableNbSentences = true),
                'body'        => $faker->text,
                'body2'       => $faker->text,
                'picture'     => $faker->imageUrl($width = 640, $height = 480),
                'open'        => $faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null)->format('Y-m-d H:i:s'),
                'robot'       => $faker->randomElement(['noindex']),
                'block'       => $faker->text,
                'keywords'    => implode(',', $faker->words($nb = 5, $asText = false)),
                'list'        => $faker->words($nb = 5, $asText = false),
            ],
        ],
        'options' => [
            'locale' => [
                'en' => 'true',
            ],
        ],
        'slug'    => ($type == 'page') ? 'demo-page' : Str::slug($name),  //'slug' => "demo-page"
    ];

    return $post;
});
