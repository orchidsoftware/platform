<?php

namespace Orchid\Database\Seeds;

use Illuminate\Database\Seeder;
use Orchid\Press\Models\Menu;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $MenuTypes = ['header', 'sidebar', 'footer'];

        foreach ($MenuTypes as $MenuType) {
            $Type = ['type' => $MenuType];

            factory(Menu::class, 5)->create($Type)->each(function ($u) use ($Type) {
                $u->children()->saveMany(factory(Menu::class, 2)->create($Type)
                    ->each(function ($p) use ($Type) {
                        $p->children()->saveMany(factory(Menu::class, 2)->make($Type));
                    }));
            });
        }
    }
}
