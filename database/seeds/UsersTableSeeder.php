<?php

namespace Orchid\Database\Seeds;

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
