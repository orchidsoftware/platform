<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Fields;

use DateTimeZone;
use Orchid\Screen\Fields\TimeZone;

/**
 * Class TimeZoneTest.
 */
class TimeZoneTest extends TestFieldsUnitCase
{
    /**
     * @test
     */
    public function testInstanse()
    {
        $textArea = TimeZone::make('time')
            ->title('Select time zone');

        $view = self::renderField($textArea);

        $this->assertStringContainsString('time', $view);
        $this->assertStringContainsString('Select time zone', $view);
    }

    /**
     * @test
     */
    public function testNeedRequire()
    {
        $textArea = TimeZone::make('time')
            ->required();

        $view = self::renderField($textArea);

        $this->assertStringContainsString('required', $view);
    }

    /**
     * @test
     */
    public function testSetValue()
    {
        $select = TimeZone::make('time')
            ->value('Africa/Accra');

        $view = self::renderField($select);
        $view = self::minifyOutput($view);

        $this->assertStringContainsString('value="Africa/Accra" selected', $view);
    }

    /**
     * @test
     */
    public function testSetMultipleValue()
    {
        $select = TimeZone::make('time')
            ->multiple()
            ->value([
                'Africa/Accra',
                'Africa/Bamako'
            ]);

        $view = self::renderField($select);
        $view = self::minifyOutput($view);

        $this->assertStringContainsString('value="Africa/Accra" selected', $view);
        $this->assertStringContainsString('value="Africa/Bamako" selected', $view);
    }

    /**
     * @test
     */
    public function testListIdentifiers()
    {
        $select = TimeZone::make('time')
            ->listIdentifiers(DateTimeZone::EUROPE)
            ->value('Africa/Accra');

        $view = self::renderField($select);
        $view = self::minifyOutput($view);

        foreach (DateTimeZone::listIdentifiers(DateTimeZone::EUROPE) as $time) {
            $this->assertStringContainsString($time, $view);
        }

        $this->assertStringNotContainsString('value="Africa/Accra" selected', $view);
    }
}
