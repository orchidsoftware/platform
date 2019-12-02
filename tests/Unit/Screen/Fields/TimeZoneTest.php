<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use DateTimeZone;
use Orchid\Screen\Fields\TimeZone;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

/**
 * Class TimeZoneTest.
 */
class TimeZoneTest extends TestFieldsUnitCase
{
    /**
     */
    public function testInstance()
    {
        $textArea = TimeZone::make('time')
            ->title('Select time zone');

        $view = self::renderField($textArea);

        $this->assertStringContainsString('time', $view);
        $this->assertStringContainsString('Select time zone', $view);
    }

    /**
     */
    public function testNeedRequire()
    {
        $textArea = TimeZone::make('time')
            ->required();

        $view = self::renderField($textArea);

        $this->assertStringContainsString('required', $view);
    }

    /**
     */
    public function testSetValue()
    {
        $select = TimeZone::make('time')
            ->value('Africa/Accra');

        $view = self::minifyRenderField($select);

        $this->assertStringContainsString('value="Africa/Accra" selected', $view);
    }

    /**
     */
    public function testSetMultipleValue()
    {
        $select = TimeZone::make('time')
            ->multiple()
            ->value([
                'Africa/Accra',
                'Africa/Bamako',
            ]);

        $view = self::minifyRenderField($select);

        $this->assertStringContainsString('value="Africa/Accra" selected', $view);
        $this->assertStringContainsString('value="Africa/Bamako" selected', $view);
    }

    /**
     */
    public function testListIdentifiers()
    {
        $select = TimeZone::make('time')
            ->listIdentifiers(DateTimeZone::EUROPE)
            ->value('Africa/Accra');

        $view = self::minifyRenderField($select);

        foreach (DateTimeZone::listIdentifiers(DateTimeZone::EUROPE) as $time) {
            $this->assertStringContainsString($time, $view);
        }

        $this->assertStringNotContainsString('value="Africa/Accra" selected', $view);
    }
}
