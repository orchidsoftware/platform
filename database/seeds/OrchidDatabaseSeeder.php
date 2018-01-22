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
		$this->call(UsersTableSeeder::class);
		$this->call(RolesTableSeeder::class);
		$this->call(SettingsTableSeeder::class);
		$this->call(TermsTableSeeder::class);
		$this->call(MenusTableSeeder::class);
		$this->call(PagesTableSeeder::class);
		$this->call(PostsTableSeeder::class);

    }
}
