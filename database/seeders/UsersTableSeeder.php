<?php

namespace Orchid\Platform\Database\Seeders;

use Illuminate\Database\Seeder;
use Orchid\Platform\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(10)->create();
    }
}
