<?php

namespace Orchid\Platform\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchid\Tests\App\Role;

/**
 * @extends Factory<Role>
 */
class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = fake()->randomElement(['Admin', 'User']);

        return [
            'name'        => fake()->unique()->lexify($name.'_??????'),
            'permissions' => [
                'orchid.index'       => 1,
                'orchid'             => 1,
                'orchid.roles'       => 1,
                'orchid.settings'    => 1,
                'orchid.users'       => 1,
                'orchid.attachment'  => 1,
                'orchid.media'       => 1,
            ],
        ];
    }
}
