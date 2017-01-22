<?php

use Settings;

class SettingsTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function oneValue()
    {

        //Запишем значение
        $key = 'test-' . str_random(40);
        $value = 'value-' . str_random(40);

        // Пробуем записать одно значение
        Settings::set($key, $value);

        //Проверяем это значение
        $result = Settings::get($key, null);
        $this->assertEquals($value, $result->value);

        //Удаляем значение
        Settings::forget($key);

        //Проверяем это значение
        $result = Settings::get($key);
        $this->assertEquals(null, $result);
    }

    public function manyValue()
    {
        $valueArray = [
            'test-1' => 'value-' . str_random(40),
            'test-2' => 'value-' . str_random(40),
            'test-3' => 'value-' . str_random(40),
        ];

        //Добавим несколько значений
        foreach ($valueArray as $key => $value) {
            Settings::set($key, $value);
        }
        //Возьмём все эти значения
        $result = Settings::get([
            'test-1',
            'test-2',
            'test-3',
        ]);

        $this->assertEquals(3, $result->count());

        //Удалим все значениея
        $result = Settings::forget([
            'test-1',
            'test-2',
            'test-3',
        ]);
        $this->assertTrue($result);
    }
}
