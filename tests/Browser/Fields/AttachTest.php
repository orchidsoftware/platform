<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser\Fields;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Dusk\Browser;
use Orchestra\Testbench\Dusk\Options;
use Orchestra\Testbench\Dusk\TestCase;
use Orchid\Platform\Providers\FoundationServiceProvider;
use Orchid\Tests\App\Fields\AttachBrowserFixture;

class AttachTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [FoundationServiceProvider::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('session.driver', 'file');
        $app['config']->set('orchid.prevents_abandonment', false);
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
            Route::get('/attach', fn () => AttachBrowserFixture::render());
            Route::post('/attach/upload', function (Request $request) {
                abort_unless($request->hasFile('file'), 422);

                return response()->json(AttachBrowserFixture::attachment(99));
            });
            Route::post('/attach/submit', fn (Request $request) => response()->json($request->except('_token')));
        });
        Route::get('/attach/image', fn () => response(base64_decode(explode(',', AttachBrowserFixture::IMAGE)[1]))->header('Content-Type', 'image/gif'));
        Route::get('/attach/assets/{file}', function (string $file) {
            abort_unless(in_array($file, ['app.js', 'app.css'], true), 404);
            $root = getenv('ORCHID_TEST_ASSET_PATH') ?: dirname(__DIR__, 3).'/public';

            return response()->file($root.'/assets/'.$file, [
                'Content-Type' => $file === 'app.js' ? 'application/javascript' : 'text/css',
            ]);
        });
    }

    public function testStoredAttachmentMetadataCannotCreateMarkupOrEventHandlers(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitFixture($browser);
            $browser->waitUntil('document.querySelectorAll(".pip img")[0].complete');
            $this->assertFalse($browser->script('return window.attachExecuted')[0]);
            $this->assertSame(AttachBrowserFixture::FILENAME, $browser->attribute('.pip img', 'title'));
            $this->assertSame(0, $browser->script('return document.querySelectorAll(".pip [onload], .pip [onerror], .pip [data-injected]").length')[0]);
            $this->assertSame(['literal" $& {url}[]', 'id" $& {url}', '/attach/image?literal="&replacement=$&', 'literal " <img src=x onerror=window.attachExecuted=true> & $& {url}', 'https://example.com/image.png?token=$&'], $browser->script(<<<'JS'
const images = [...document.querySelectorAll('.pip img')];
const input = images[1].closest('.pip').querySelector('input');
return [input.name, input.value, images[1].getAttribute('src'), images[1].title, images[2].getAttribute('src')];
JS)[0]);
        });
    }

    public function testUploadResponseMetadataCannotExecuteAndItsIdIsPosted(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitFixture($browser);
            $browser->script(<<<'JS'
window.attachExecuted = false;
const element = [...document.querySelectorAll('[data-controller="attach"]')].find(element => element.dataset.attachNameValue === 'uploaded[]');
const files = new DataTransfer();
files.items.add(new File(['image content'], 'upload.gif', {type: 'image/gif'}));
const input = element.querySelector('[data-attach-target="files"]');
input.files = files.files;
input.dispatchEvent(new Event('change', {bubbles: true}));
JS);
            $browser->waitUntil('document.querySelectorAll(".pip").length === 5 && [...document.querySelectorAll(".pip img")].filter(image => image.src.startsWith("data:")).every(image => image.complete)');
            $this->assertFalse($browser->script('return window.attachExecuted')[0]);
            $this->assertSame(AttachBrowserFixture::FILENAME, $browser->script('return document.querySelector(\'.pip input[value="99"]\').closest(".pip").querySelector("img").title')[0]);
            $browser->press('Submit')->waitForText('uploaded');
            $payload = $this->submitted($browser);
            $this->assertSame(['11'], $payload['stored']);
            $this->assertSame(['99'], $payload['uploaded']);
        });
    }

    public function testClonedAttachmentRemovalLeavesOriginalIdInPostedForm(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitFixture($browser);
            $browser->click('[data-repeater-name="rows"] [data-repeater-clone]')
                ->waitUntil('document.querySelectorAll(\'[data-repeater-name="rows"] .pip\').length === 2');
            $this->assertSame(['42', '42'], $browser->script('return [...document.querySelectorAll(\'[data-repeater-name="rows"] .pip input\')].map(input => input.value)')[0]);
            $browser->click('[data-repeater-name="rows"] [data-repeater-row]:nth-child(2) .pip button');
            $browser->press('Submit')->waitForText('rows');
            $this->assertSame([['files' => ['42']]], $this->submitted($browser)['rows']);
        });
    }

    private function visitFixture(Browser $browser): void
    {
        $browser->visit('/attach')->waitUntil(<<<'JS'
window.application && [...document.querySelectorAll('[data-controller="attach"]')].every(element => window.application.getControllerForElementAndIdentifier(element, 'attach')) && document.querySelectorAll('.pip').length === 4
JS);
    }

    private function submitted(Browser $browser): array
    {
        return json_decode($browser->script('return document.querySelector("pre")?.textContent ?? document.body.textContent')[0], true, 512, JSON_THROW_ON_ERROR);
    }
}
