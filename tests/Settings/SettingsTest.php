<?php

namespace Tests\Settings;

use Illuminate\Foundation\Testing\TestCase;
use Orchid\Settings\Facades\Setting;
use Tests\CreatesApplicationOrchid;

class SettingsTest extends TestCase
{
    use CreatesApplicationOrchid;

    /**
     * A basic test example.
     */
    public function oneValue()
    {

        //Запишем значение
        $key = 'test-'.str_random(40);
        $value = 'value-'.str_random(40);

        // Пробуем записать одно значение
        Setting::set($key, $value);

        //Проверяем это значение
        $result = Setting::get($key, null);
        $this->assertEquals($value, $result->value);

        //Удаляем значение
        Setting::forget($key);

        //Проверяем это значение
        $result = Setting::get($key);
        $this->assertEquals(null, $result);
    }

    public function manyValue()
    {
        $valueArray = [
            'test-1' => 'value-'.str_random(40),
            'test-2' => 'value-'.str_random(40),
            'test-3' => 'value-'.str_random(40),
        ];

        //Добавим несколько значений
        foreach ($valueArray as $key => $value) {
            Setting::set($key, $value);
        }
        //Возьмём все эти значения
        $result = Setting::get([
            'test-1',
            'test-2',
            'test-3',
        ]);

        $this->assertEquals(3, $result->count());

        //Удалим все значениея
        $result = Setting::forget([
            'test-1',
            'test-2',
            'test-3',
        ]);
        $this->assertTrue($result);
    }
}
