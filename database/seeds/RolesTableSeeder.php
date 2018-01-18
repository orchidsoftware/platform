<?php

use Illuminate\Database\Seeder;
use Orchid\Platform\Core\Models\Role;

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
