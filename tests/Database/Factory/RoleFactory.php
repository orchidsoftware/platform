<?php

namespace Orchid\Platform\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchid\Tests\App\Role;

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
        $role = ['Admin', 'User'];
        $roles = [
            $role[0] => [
                'orchid.index'       => 1,
                'orchid'             => 1,
                'orchid.roles'       => 1,
                'orchid.settings'    => 1,
                'orchid.users'       => 1,
                'orchid.attachment'  => 1,
                'orchid.media'       => 1,
            ],
            $role[1] => [
                'orchid.index'       => 1,
                'orchid'             => 1,
                'orchid.settings'    => 1,
                'orchid.comment'     => 1,
                'orchid.attachment'  => 1,
                'orchid.media'       => 1,
            ],
        ];

        $selRole = $this->faker->randomElement($role);

        return [
            'name'        => $this->faker->lexify($selRole.'_???'),
            'slug'        => $this->faker->unique()->jobTitle,
            'permissions' => $roles[$selRole],
        ];
    }
}
