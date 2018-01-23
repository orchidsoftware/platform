<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Orchid\Platform\Core\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $settings = [
            [
                'key'   => 'site_adress',
                'value' => $faker->streetAddress,
            ], [
                'key'   => 'site_description',
                'value' => $faker->sentence($nbWords = 6, $variableNbWords = true),
            ], [
                'key'   => 'site_email',
                'value' => $faker->companyEmail,
            ], [
                'key'   => 'site_keywords',
                'value' => implode(', ', $faker->words($nb = 5, $asText = false)),
            ], [
                'key'   => 'site_phone',
                'value' => $faker->tollFreePhoneNumber,
            ], [
                'key'   => 'site_title',
                'value' => $faker->catchPhrase,
            ], [
                'key'   => 'anykey',
                'value' => $faker->catchPhrase,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], [
                'key'   => $setting['key'],
                'value' => $setting['value'],
            ]);
        }
    }
}
