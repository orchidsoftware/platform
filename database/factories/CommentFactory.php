<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Faker\Generator as Faker;
use Orchid\Platform\Core\Models\Comment;
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

$factory->define(Comment::class, function (Faker $faker) {

	$user		=	User::inRandomOrder()->first()->id;
			
    return [
        'user_id'	=> $user,
        'parent_id'	=> 0,
        'content'	=> $faker->paragraph($nbSentences = 2, $variableNbSentences = true),
        'approved'	=> $faker->randomElement([0,1]),
    ];
});