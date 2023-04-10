<?php

namespace Orchid\Platform\Database\Seeders;

use Illuminate\Database\Seeder;
use Orchid\Platform\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Role::class, 5)->create();
    }
}
