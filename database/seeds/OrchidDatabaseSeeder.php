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
		$this->call([
            UsersTableSeeder::class,
            RolesTableSeeder::class,
            SettingsTableSeeder::class,
            TermsTableSeeder::class,
            MenusTableSeeder::class,
			PagesTableSeeder::class,
			PostsTableSeeder::class
        ]);

    }
}
