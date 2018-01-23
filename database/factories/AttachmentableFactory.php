<?php

use Faker\Generator as Faker;
use Orchid\Platform\Core\Models\Attachment;
use Orchid\Platform\Core\Models\Attachmentable;

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

    if ($attachments > 0) {
        $attachment = [
            'attachmentable_type' => "Orchid\Platform\Core\Models\Post",
            'attachment_id'       => Attachment::inRandomOrder()->first()->id,
        ];
    } else {
        $attachment = [];
    }

    return $attachment;
});
