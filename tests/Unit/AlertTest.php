<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Toast;
use Orchid\Tests\TestUnitCase;

/**
 * Class AlertTest.
 */
class AlertTest extends TestUnitCase
{
    public function test_html_sanitize(): void
    {
        Alert::info('<h1>Hello Word</h1>');

        self::assertEquals('&lt;h1&gt;Hello Word&lt;/h1&gt;', session('flash_notification.message'));
    }

    public function test_without_sanitize(): void
    {
        Alert::withoutEscaping()->info('<h1>Hello Word</h1>');

        self::assertEquals('<h1>Hello Word</h1>', session('flash_notification.message'));
    }

    public function test_helper_alert(): void
    {
        alert('test');

        self::assertEquals('test', session('flash_notification.message'));
        self::assertEquals('info', session('flash_notification.level'));

        self::assertInstanceOf(\Orchid\Alert\Alert::class, alert());
    }

    /**
     * @dataProvider getLevels
     */
    public function test_should_flash_levels_alert(string $level, string $css): void
    {
        Alert::$level('test');

        self::assertEquals('test', session('flash_notification.message'));
        self::assertEquals($css, session('flash_notification.level'));
    }

    /**
     * @dataProvider getLevels
     */
    public function test_should_flash_levels_toast(string $level, string $css): void
    {
        Toast::$level('test');

        self::assertEquals('test', session('toast_notification.message'));
        self::assertEquals($css, session('toast_notification.level'));
    }

    public function test_should_toast_value(): void
    {
        Toast::info('Hello Alexandr!')
            ->autoHide(false)
            ->delay(3000);

        self::assertEquals('Hello Alexandr!', session('toast_notification.message'));
        self::assertEquals('false', session('toast_notification.auto_hide'));
        self::assertEquals('3000', session('toast_notification.delay'));
    }

    public function test_should_flash_view_alert(): void
    {
        Alert::view('exemplar::alert', Color::INFO, [
            'name' => 'Alexandr',
        ]);

        self::assertEquals('Hello Alexandr!', session('flash_notification.message'));
        self::assertEquals('info', session('flash_notification.level'));
    }

    public function test_should_check_alert(): void
    {
        self::assertFalse(Alert::check());

        Alert::info('check alert');

        self::assertTrue(Alert::check());
    }

    /**
     * Array of keys and css classes.
     */
    public static function getLevels(): array
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
