<?php

namespace Orchid\Platform\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchid\Platform\Models\Role;

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
                'platform.index'              => 1,
                'platform.systems'            => 1,
                'platform.systems.roles'      => 1,
                'platform.systems.settings'   => 1,
                'platform.systems.users'      => 1,
                'platform.systems.attachment' => 1,
                'platform.systems.media'      => 1,
            ],
            $role[1] => [
                'platform.index'              => 1,
                'platform.systems'            => 1,
                'platform.systems.settings'   => 1,
                'platform.systems.comment'    => 1,
                'platform.systems.attachment' => 1,
                'platform.systems.media'      => 1,
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
