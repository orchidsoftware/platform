<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Illuminate\Support\Str;
use Orchid\Setting\Setting;
use Orchid\Tests\TestUnitCase;

class SettingsTest extends TestUnitCase
{
    /**
     * Setting Model.
     *
     * @var Setting
     */
    public $setting;

    /** */
    public function test_for_one_value()
    {
        //Запишем значение
        $key = 'test-'.Str::random(40);
        $value = 'value-'.Str::random(40);

        $this->setting->set($key, $value);

        $result = $this->setting->get($key);

        $this->assertEquals($value, $result);

        //Удаляем значение
        $this->setting->forget($key);

        //Проверяем это значение
        $result = $this->setting->get($key);

        $this->assertEquals(null, $result);
    }

    /** */
    public function test_for_many_value()
    {
        $valueArray = [
            'test-1' => 'value-'.Str::random(40),
            'test-2' => 'value-'.Str::random(40),
            'test-3' => 'value-'.Str::random(40),
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

        $this->assertCount(3, $result);

        //Удалим все значениея
        $result = $this->setting->forget([
            'test-1',
            'test-2',
            'test-3',
        ]);

        $this->assertEquals(3, $result);
    }

    public function test_use_helper()
    {
        $this->setting->set('helper', 'run');

        $this->assertEquals('run', setting('helper'));

        $this->assertEquals('default', setting('not-found', 'default'));
    }

    protected function setUp() : void
    {
        parent::setUp();
        $setting = new Setting();
        $setting->cache = false;
        $this->setting = $setting;
    }
}
