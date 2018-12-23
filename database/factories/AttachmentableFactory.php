<?php

use Faker\Generator as Faker;
use Orchid\Attachment\Models\Attachment;
use Orchid\Attachment\Models\Attachmentable;

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

$factory->define(Attachmentable::class, function (Faker $faker) {
    $attachments = Attachment::get()->count();

    return $attachments > 0 ? [
        'attachmentable_type' => "Orchid\Press\Models\Post",
        'attachment_id'       => Attachment::inRandomOrder()->first()->id,
    ] : [];
});
