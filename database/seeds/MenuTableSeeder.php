<?php

use Illuminate\Database\Seeder;

use Orchid\Platform\Core\Models\Menu;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Menu::class, 30)->create();
        factory(Menu::class, 30)->create();
    }
}
