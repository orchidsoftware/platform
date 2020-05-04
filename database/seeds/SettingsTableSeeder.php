<?php

namespace Orchid\Database\Seeds;

use Illuminate\Database\Seeder;
use Orchid\Setting\Setting;

/**
 * Class SettingsTableSeeder
 *
 * @deprecated
 */
class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Setting::class)->create();
    }
}
