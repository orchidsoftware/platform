<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Tests\TestUnitCase;
use Orchid\Support\Facades\Alert;

/**
 * Class AlertTest.
 */
class AlertTest extends TestUnitCase
{
    /** @test */
    public function testHelperAlert()
    {
        alert('test');

        self::assertEquals('test', session('flash_notification.message'));
        self::assertEquals('info', session('flash_notification.level'));
    }

    /**
     * @dataProvider getLevels
     *
     * @param $level
     * @param $css
     */
    public function testShouldFlashLevelsAlert(string $level, string $css)
    {
        Alert::$level('test');

        self::assertEquals('test', session('flash_notification.message'));
        self::assertEquals($css, session('flash_notification.level'));
    }

    /**
     * Array of keys and css classes.
     *
     * @return array
     */
    public function getLevels() :array
    {
        return [
            [
                'info',
                'info',
            ],
            [
                'success',
                'success',
            ],
            [
                'error',
                'danger',
            ],
            [
                'warning',
                'warning',
            ],
        ];
    }
}
