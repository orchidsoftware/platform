<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser\Fields;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Dusk\Browser;
use Orchestra\Testbench\Dusk\Options;
use Orchestra\Testbench\Dusk\TestCase;
use Orchid\Platform\Providers\FoundationServiceProvider;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Markdown;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\NumberRange;
use Orchid\Screen\Fields\RadioButtons;
use Orchid\Screen\LayoutFactory;
use Orchid\Screen\Repository;

class BootstrapTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [FoundationServiceProvider::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('session.driver', 'file');
    }

    protected static function defineChromeDriver(): void
    {
        if ($binary = getenv('DUSK_CHROME_BINARY')) {
            static::useChromedriver($binary);
        }

        Options::withoutUI();
        parent::defineChromeDriver();
    }

    protected function defineRoutes($router): void
    {
        Route::middleware('web')->group(function () {
            Route::get('/bootstrap-fields', function () {
                $layout = LayoutFactory::tabs([
                    'Fields' => LayoutFactory::rows([
                        DateRange::make('period')->format('Y-m-d')->disableMobile()
                            ->value(['start' => '2026-10-10', 'end' => '2026-10-12']),
                        NumberRange::make('price')->value(['min' => 10, 'max' => 20]),
                        DateTimer::make('appointment')->format('Y-m-d')->allowEmpty()->disableMobile()->value('2026-10-10'),
                        DateTimer::make('locked')->allowEmpty()->readonly()->value('2026-10-10'),
                        RadioButtons::make('status')->options(['draft' => 'Draft', 'published' => 'Published'])->value('draft'),
                        Matrix::make('items')->columns(['Name' => 'name'])->maxRows(2)->value([['name' => 'Existing']]),
                        Markdown::make('notes')->readonly()->value('Existing notes'),
                    ]),
                    'Details' => LayoutFactory::rows([Input::make('details')->value('Saved details')]),
                ])->build(new Repository())->render();
                $token = csrf_token();

                return '<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">'
                    .'<link rel="stylesheet" href="/bootstrap-assets/app.css"><script type="module" src="/bootstrap-assets/app.js"></script>'
                    .'</head><body class="bg-light"><main class="container py-3"><h1 class="h3">Bootstrap fields</h1>'
                    .'<form method="post" action="/bootstrap-fields" data-turbo="false"><input type="hidden" name="_token" value="'.$token.'">'
                    .$layout.'<button class="btn btn-default" type="submit">Save fields</button></form></main></body></html>';
            });
            Route::post('/bootstrap-fields', fn (Request $request) => response()->json($request->except('_token')));
        });

        Route::get('/bootstrap-assets/{file}', function (string $file) {
            abort_unless(in_array($file, ['app.js', 'app.css'], true), 404);
            $root = getenv('ORCHID_TEST_ASSET_PATH') ?: dirname(__DIR__, 3).'/public';

            return response()->file($root.'/assets/'.$file, [
                'Content-Type' => $file === 'app.js' ? 'application/javascript' : 'text/css',
            ]);
        });
    }

    public function testExistingValuesNativeControlsAndMatrixSurviveAtDesktopAndMobileWidths(): void
    {
        $this->browse(function (Browser $browser) {
            foreach ([1440, 390] as $width) {
                $browser->driver->executeCustomCommand('/session/:sessionId/goog/cdp/execute', 'POST', [
                    'cmd'    => 'Emulation.setDeviceMetricsOverride',
                    'params' => ['width' => $width, 'height' => 1000, 'deviceScaleFactor' => 1, 'mobile' => false],
                ]);
                $browser->resize($width, 1000)->visit('/bootstrap-fields')
                    ->waitUntil('document.querySelector("[name=appointment]")._flatpickr !== undefined');
                $this->assertSame($width, $browser->script('return window.innerWidth')[0]);
                $this->assertSame('true', $browser->attribute('[role="tab"].active', 'aria-selected'));
                $this->assertTrue($browser->script('return document.documentElement.scrollWidth <= window.innerWidth')[0]);
                $this->assertTrue($browser->script('return document.querySelector("[name=locked]").closest("[data-controller=datetime]").querySelector("button").disabled')[0]);
                $this->assertTrue($browser->script('return [...document.querySelectorAll("[data-controller=markdown] button")].every(button => button.disabled)')[0]);
                $radioId = $browser->attribute('input[name="status"][value="published"]', 'id');
                $browser->click('label[for="'.$radioId.'"]')
                    ->click('[data-action="matrix#addRow"]')
                    ->type('items[1][name]', 'Added')
                    ->assertMissing('[data-action="matrix#addRow"]')
                    ->click('[data-controller="matrix"] tbody tr:first-child [data-action="matrix#deleteRow"]')
                    ->assertVisible('[data-action="matrix#addRow"]')
                    ->click('[name="appointment"] + button')
                    ->assertInputValue('appointment', '')
                    ->click('[role="tablist"] li:last-child a')
                    ->assertVisible('input[name="details"]')
                    ->click('[role="tablist"] li:first-child a');
                $this->assertSame('true', $browser->attribute('[role="tab"].active', 'aria-selected'));
                if ($directory = getenv('ORCHID_UI_SCREENSHOTS')) {
                    $browser->driver->takeScreenshot($directory.'/bootstrap-'.$width.'.png');
                }
                $browser->press('Save fields')->waitForText('Added');
                $payload = json_decode($browser->script('return document.querySelector("pre")?.textContent ?? document.body.textContent')[0], true, 512, JSON_THROW_ON_ERROR);
                $this->assertSame(['start' => '2026-10-10', 'end' => '2026-10-12'], $payload['period']);
                $this->assertSame(['min' => '10', 'max' => '20'], $payload['price']);
                $this->assertSame('published', $payload['status']);
                $this->assertSame(['Added'], array_column($payload['items'], 'name'));
                $this->assertSame('Existing notes', $payload['notes']);
                $this->assertSame('Saved details', $payload['details']);
            }
        });
    }
}
