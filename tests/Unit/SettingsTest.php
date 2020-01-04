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

    public function testForOneValue()
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

    public function testForManyValue()
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

    public function testForRewriteCache()
    {
        $this->setting->set('cache-key', 'old');
        $this->setting->get('cache-key');

        $this->setting->set('cache-key', 'new');
        $this->assertStringContainsString('new', $this->setting->get('cache-key'));
    }

    /**
     * @dataProvider notExitstValues
     *
     * @param $defaultValue
     */
    public function testDefaultValue($defaultValue)
    {
        $value = $this->setting->get('nonexistent value', $defaultValue);

        $this->assertEquals(gettype($defaultValue), gettype($value));
        $this->assertEquals($defaultValue, $value);
    }

    /**
     * @return array
     */
    public function notExitstValues(): array
    {
        return [
            ['string'],
            [123],
            [new \stdClass()],
            [['test', 123]],
        ];
    }

    public function testUseHelper()
    {
        $this->setting->set('helper', 'run');

        $this->assertEquals('run', setting('helper'));

        $this->assertEquals('default', setting('not-found', 'default'));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $setting = new Setting();
        $setting->cache = false;
        $this->setting = $setting;
    }
}
