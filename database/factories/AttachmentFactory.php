<?php

namespace Orchid\Platform\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;

class AttachmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attachment::class;

    /**
     * Define the model's default state.
     *
     * @throws \Exception
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'          => Str::random(),
            'original_name' => Str::random(),
            'mime'          => 'unknown',
            'extension'     => 'unknown',
            'size'          => random_int(1, 100),
            'sort'          => random_int(1, 100),
            'path'          => Str::random(),
            'description'   => Str::random(),
            'alt'           => Str::random(),
            'hash'          => Str::random(),
            'disk'          => 'public',
            'group'         => null,
        ];
    }
}
