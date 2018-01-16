<?php

use Faker\Generator as Faker;
use Orchid\Platform\Core\Models\Setting;

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

$factory->define(Setting::class, function (Faker $faker) {
    return [
        'key' => str_random(10),
        'value' => str_random(10),
    ];
});
