<?php

namespace Orchid\Platform\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Orchid\Platform\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $roles = [
            'admin'  => [
                'orchid.index'       => 1,
                'orchid'             => 1,
                'orchid.roles'       => 1,
                'orchid.settings'    => 1,
                'orchid.users'       => 1,
                'orchid.comment'     => 1,
                'orchid.attachment'  => 1,
                'orchid.media'       => 1,
            ],
            'user'   => [
                'orchid.index'       => 1,
                'orchid'             => 1,
                'orchid.roles'       => 0,
                'orchid.settings'    => 1,
                'orchid.users'       => 0,
                'orchid.menu'        => 0,
                'orchid.attachment'  => 1,
                'orchid.media'       => 1,
            ],
        ];

        return [
            'name'           => $this->faker->firstName,
            'email'          => $this->faker->unique()->safeEmail,
            'password'       => Hash::make('password'),
            'remember_token' => Str::random(10),
            'permissions'    => $roles['admin'],
        ];
    }
}
