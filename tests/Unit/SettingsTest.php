<?php

namespace Orchid\Platform\Tests\Unit;

use Orchid\Platform\Tests\TestUnitCase;
use Orchid\Platform\Core\Models\Setting;

class SettingsTest extends TestUnitCase
{
    /**
     * Database connect.
     *
     * @var
     */
    public $capsule;

    /**
     * Setting Model.
     *
     * @var
     */
    public $setting;

    /** @test */
    public function testOneValue()
    {
        $setting = new Setting();
        $setting->cache = false;
        $this->setting = $setting;

        //Запишем значение
        $key = 'test-'.str_random(40);
        $value = 'value-'.str_random(40);

        $this->setting->set($key, $value);

        $result = $this->setting->get($key, null);

        $this->assertEquals($value, $result);

        //Удаляем значение
        $this->setting->forget($key);

        //Проверяем это значение
        $result = $this->setting->get($key);

        $this->assertEquals(null, $result);
    }

    /** @test */
    public function testManyValue()
    {
        $setting = new Setting();
        $setting->cache = false;
        $this->setting = $setting;

        $valueArray = [
            'test-1' => 'value-'.str_random(40),
            'test-2' => 'value-'.str_random(40),
            'test-3' => 'value-'.str_random(40),
        ];

        //Добавим несколько значений
        foreach ($valueArray as $key => $value) {
            $this->setting->set($key, $value);
        }
        //Возьмём все эти значения
        $result = $this->setting->get([
            'test-1',
            'test-2',
            'test-3',
        ]);

        $this->assertEquals(3, count($result));

        //Удалим все значениея
        $result = $this->setting->forget([
            'test-1',
            'test-2',
            'test-3',
        ]);

        $this->assertEquals(3, $result);
    }
}
