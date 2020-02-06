<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Illuminate\Support\Facades\Route;
use Orchid\Platform\Http\Middleware\TurbolinksLocation;
use Orchid\Tests\TestUnitCase;

class TurbolinksLocationTest extends TestUnitCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware(TurbolinksLocation::class)->group(static function () {
            Route::post('turbolink-html-response-test', static function () {
                return response()->make('Availability headers location');
            });

            Route::post('turbolink-json-response-test', static function () {
                return response()->json([
                    'Availability headers location',
                ]);
            });

            Route::post('turbolink-stream-response-test', static function () {
                return response()->streamDownload(function () {
                    echo 'Not headers location';
                }, 'test.md');
            });

            Route::post('turbolink-file-response-test', static function () {
                return response()->download(__FILE__);
            });
        });
    }

    public function testHtmlResponse()
    {
        $response = $this->post('turbolink-html-response-test');
        $response->assertHeader('Turbolinks-Location', url('turbolink-html-response-test'));
    }

    public function testJsonResponse()
    {
        $response = $this->post('turbolink-json-response-test');
        $response->assertHeader('Turbolinks-Location', url('turbolink-json-response-test'));
    }

    public function testStreamResponse()
    {
        $response = $this->post('turbolink-stream-response-test');
        $response->assertHeaderMissing('Turbolinks-Location', );
    }

    public function testFileResponse()
    {
        $response = $this->post('turbolink-file-response-test');
        $response->assertHeaderMissing('Turbolinks-Location', );
    }
}
