<?php

use Illuminate\Database\Seeder;
use Orchid\Platform\Core\Models\User;
use Orchid\Platform\Core\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 2)->create();
		/*->each(function ($u) {
            $u->appointments()->saveMany(factory(App\Core\Models\Appointment::class, 100)->make());
            $u->invoices()->saveMany(factory(App\Core\Models\Invoice::class, 100)->make());
        });*/
    }
}
