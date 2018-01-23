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
        [
            'key'   => 'site_adress',
            'value' => $faker->streetAddress,
        ], [
            'key'   => 'site_description',
            'value' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        ], [
            'key'   => 'site_email',
            'value' => $faker->companyEmail,
        ], [
            'key'   => 'site_keywords',
            'value' => implode(', ', $faker->words($nb = 5, $asText = false)),
        ], [
            'key'   => 'site_phone',
            'value' => $faker->tollFreePhoneNumber,
        ], [
            'key'   => 'site_title',
            'value' => $faker->catchPhrase,
        ], [
            'key'   => 'anykey',
            'value' => $faker->catchPhrase,
        ],
    ];
});
