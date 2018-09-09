<?php

use Faker\Generator as Faker;
use Orchid\Press\Models\Post;

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

    $type = $faker->randomElement(['demo']);

    $status = ['publish'];

    $name = $faker->sentence(6);

    return [
        'type'       => $type,
        'status'     => $faker->randomElement($status),
        'content'    => [
            'en' => [
                'name'        => $name,
                'title'       => $faker->sentence(6),
                'description' => $faker->paragraph(2),
                'body'        => $faker->text,
                'body2'       => $faker->text,
                'picture'     => $faker->imageUrl(640, 480),
                'open'        => $faker->dateTimeBetween('-30 years', 'now')->format('Y-m-d H:i:s'),
                'robot'       => $faker->randomElement(['noindex']),
                'block'       => $faker->text,
                'keywords'    => implode(',', $faker->words(5)),
                'list'        => $faker->words(5),
            ],
        ],
        'publish_at' => $faker->date('Y-m-d H:i:s'),
        'options'    => [
            'locale' => [
                'en' => 'true',
            ],
        ],
        'slug'       => ($type == 'page') ? 'demo-page' : str_slug($name), //'slug' => "demo-page"
    ];


});
