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
        factory(User::class, 10)->create();
    }
}
