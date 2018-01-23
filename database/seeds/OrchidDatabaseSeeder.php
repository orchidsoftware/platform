<?php

use Illuminate\Database\Seeder;

class OrchidDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
<<<<<<< HEAD
        $this->call([
=======
		
		$this->call([
			AttachmentsTableSeeder::class,
>>>>>>> master
            UsersTableSeeder::class,
            RolesTableSeeder::class,
            SettingsTableSeeder::class,
            TermsTableSeeder::class,
<<<<<<< HEAD
            MenuTableSeeder::class,
        ]);

        /*
        //////factory(Setting::class, 1)->create();
        //factory(Menu::class, 30)->create();
        */
    }
}
=======
            MenusTableSeeder::class,
			PagesTableSeeder::class,
			PostsTableSeeder::class
        ]);
	}
}
>>>>>>> master
