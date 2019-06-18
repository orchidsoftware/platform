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

        self::assertInstanceOf(\Orchid\Alert\Alert::class, alert());
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
     * @test
     */
    public function testShouldFlashViewAlert()
    {
        Alert::view('exemplar::alert', 'info', [
            'name' => 'Alexandr',
        ]);

        self::assertEquals('Hello Alexandr!', session('flash_notification.message'));
        self::assertEquals('info', session('flash_notification.level'));
    }

    /**
     * @test
     */
    public function testShouldCheckAlert()
    {
        self::assertFalse(Alert::check());

        Alert::info('check alert');

        self::assertTrue(Alert::check());
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
