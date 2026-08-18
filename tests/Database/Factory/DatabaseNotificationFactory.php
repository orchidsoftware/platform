<?php

declare(strict_types=1);

namespace Orchid\Tests\Database\Factory;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Str;
use Orchid\Platform\Notifications\OrchidMessage;

class DatabaseNotificationFactory extends Factory
{
    protected $model = DatabaseNotification::class;

    public function definition(): array
    {
        return [
            'id'      => (string) Str::uuid(),
            'type'    => OrchidMessage::class,
            'data'    => [],
            'read_at' => null,
        ];
    }
}
