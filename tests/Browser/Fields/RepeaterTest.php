<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser\Fields;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Dusk\Browser;
use Orchestra\Testbench\Dusk\Options;
use Orchestra\Testbench\Dusk\TestCase;
use Orchid\Platform\Providers\FoundationServiceProvider;
use Orchid\Tests\App\Fields\RepeaterBrowserFixture;

class RepeaterTest extends TestCase
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
            Route::get('/repeater', fn () => RepeaterBrowserFixture::render());
            Route::get('/repeater/sparse', function () {
                session()->flashInput(['sparse' => [1 => ['name' => 'First'], 2 => ['name' => 'Second']]]);

                return RepeaterBrowserFixture::render();
            });
            Route::post('/repeater/submit', fn (Request $request) => response()->json($request->except('_token')));
            Route::post('/repeater/upload', fn () => response()->json([
                'id' => 99, 'url' => '/favicon.ico', 'original_name' => 'uploaded.png', 'mime' => 'image/png',
            ]));
        });

        Route::get('/repeater/assets/{file}', function (string $file) {
            abort_unless(in_array($file, ['app.js', 'app.css'], true), 404);
            $root = getenv('ORCHID_TEST_ASSET_PATH') ?: dirname(__DIR__, 3).'/public';

            return response()->file($root.'/assets/'.$file, [
                'Content-Type' => $file === 'app.js' ? 'application/javascript' : 'text/css',
            ]);
        });
    }

    public function testQuillCloneEditReorderAndDeleteSubmitIndependentValues(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitFixture($browser);
            $browser->click('[data-repeater-name="articles"] [data-repeater-clone]')
                ->waitUntil('document.querySelectorAll(\'[data-repeater-name="articles"] .ql-editor\').length === 2');

            $browser->script(<<<'JS'
const editors = [...document.querySelectorAll('[data-repeater-name="articles"] [data-controller="quill"]')];
const controller = window.application.getControllerForElementAndIdentifier(editors[1], 'quill');
controller.editor.setText('Edited clone');
JS);
            $browser->click('[data-repeater-name="articles"] [data-repeater-row]:nth-child(2) [data-action="repeater#moveUp"]')
                ->waitUntil('document.querySelectorAll(\'[data-repeater-name="articles"] .ql-toolbar\').length === 2');
            $this->assertSame(2, $browser->script('return document.querySelectorAll(\'[data-repeater-name="articles"] .ql-toolbar\').length')[0]);
            $this->assertSame('<p>Edited clone</p>', $this->formValue($browser, 'articles[0][body]'));
            $this->assertSame('<p>Original</p>', $this->formValue($browser, 'articles[1][body]'));

            $browser->click('[data-repeater-name="articles"] [data-repeater-row]:nth-child(2) [data-action="repeater#deleteRow"]');
            $browser->press('Submit')->waitForText('Edited clone');
            $payload = json_decode($browser->script('return document.querySelector("pre")?.textContent ?? document.body.textContent')[0], true, 512, JSON_THROW_ON_ERROR);
            $this->assertSame([['body' => '<p>Edited clone</p>']], $payload['articles']);
        });
    }

    public function testAttachClonePreservesIdsAndIndependentWidgetState(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitFixture($browser);
            $browser->script(<<<'JS'
const element = document.querySelector('[data-repeater-name="uploads"] [data-controller="attach"]');
const controller = window.application.getControllerForElementAndIdentifier(element, 'attach');
const attachment = {id: 42, url: '/favicon.ico', original_name: 'fixture.png', mime: 'image/png'};
controller.attachmentValue = [attachment];
controller.renderPreview(attachment);
JS);
            $browser->click('[data-repeater-name="uploads"] [data-repeater-clone]')
                ->waitUntil("document.querySelectorAll('[data-repeater-name=\"uploads\"] .pip').length === 2");
            $this->assertSame('42', $this->formValue($browser, 'uploads[0][files][]'));
            $this->assertSame('42', $this->formValue($browser, 'uploads[1][files][]'));
            $browser->click('[data-repeater-name="uploads"] [data-repeater-row]:nth-child(2) .pip button');
            $this->assertSame('42', $this->formValue($browser, 'uploads[0][files][]'));
            $this->assertNull($this->formValue($browser, 'uploads[1][files][]'));
        });
    }

    public function testRadioButtonsPreserveDistinctRowSelectionsAfterMoveAndClone(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitFixture($browser);
            $this->assertSame('draft', $this->formValue($browser, 'choices[0][status]'));
            $this->assertSame('published', $this->formValue($browser, 'choices[1][status]'));
            $browser->click('[data-repeater-name="choices"] [data-repeater-row]:nth-child(2) [data-action="repeater#moveUp"]');
            $this->assertSame('published', $this->formValue($browser, 'choices[0][status]'));
            $this->assertSame('draft', $this->formValue($browser, 'choices[1][status]'));

            $browser->click('[data-repeater-name="choices"] [data-repeater-row]:nth-child(1) [data-repeater-clone]')
                ->waitUntil('document.querySelectorAll(\'[data-repeater-name="choices"] [data-repeater-row]\').length === 3');
            $this->assertSame('published', $this->formValue($browser, 'choices[1][status]'));
            $radioId = $browser->attribute('input[name="choices[1][status]"][value="archived"]', 'id');
            $browser->click('label[for="'.$radioId.'"], label:has(input[id="'.$radioId.'"])');
            $this->assertSame('published', $this->formValue($browser, 'choices[0][status]'));
            $this->assertSame('archived', $this->formValue($browser, 'choices[1][status]'));
            $this->assertSame('draft', $this->formValue($browser, 'choices[2][status]'));

            $browser->press('Submit')->waitForText('archived');
            $payload = json_decode($browser->script('return document.querySelector("pre")?.textContent ?? document.body.textContent')[0], true, 512, JSON_THROW_ON_ERROR);
            $this->assertSame([
                ['status' => 'published'], ['status' => 'archived'], ['status' => 'draft'],
            ], $payload['choices']);
        });
    }

    public function testAttachCloneAndPostPreserveTheVisibleSortedIds(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitFixture($browser);
            $browser->script(<<<'JS'
const element = document.querySelector('[data-repeater-name="uploads"] [data-controller="attach"]');
const controller = window.application.getControllerForElementAndIdentifier(element, 'attach');
const attachments = [
    {id: 71, url: '/favicon.ico', original_name: 'first.png', mime: 'image/png'},
    {id: 72, url: '/favicon.ico', original_name: 'second.png', mime: 'image/png'},
];
controller.attachmentValue = attachments;
attachments.forEach(attachment => controller.renderPreview(attachment));
const previews = element.querySelectorAll('.pip');
previews[0].before(previews[1]);
controller.sortable.option('onEnd')();
JS);
            $this->assertSame(['72', '71'], $browser->script('return new FormData(document.querySelector("#fixture")).getAll("uploads[0][files][]")')[0]);
            $browser->click('[data-repeater-name="uploads"] [data-repeater-clone]')
                ->waitUntil('document.querySelectorAll(\'[data-repeater-name="uploads"] .pip\').length === 4');
            $this->assertSame(['72', '71'], $browser->script('return [...document.querySelectorAll(\'[data-repeater-name="uploads"] [data-repeater-row]:nth-child(2) .pip input\')].map(input => input.value)')[0]);

            $browser->press('Submit')->waitForText('uploads');
            $payload = json_decode($browser->script('return document.querySelector("pre")?.textContent ?? document.body.textContent')[0], true, 512, JSON_THROW_ON_ERROR);
            $this->assertSame([['files' => ['72', '71']], ['files' => ['72', '71']]], $payload['uploads']);
        });
    }

    public function testReadonlyAttachIdsAndEmptyNullableSubmitOnlyToTheirOwningForm(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitFixture($browser);
            $this->assertNull($this->formValue($browser, 'external_uploads[0][files][]'));
            $this->assertNull($this->formValue($browser, 'external_uploads[0][empty]'));
            $this->assertSame(['61'], $browser->script('return new FormData(document.querySelector("#other")).getAll("external_uploads[0][files][]")')[0]);
            $this->assertSame(['0'], $browser->script('return new FormData(document.querySelector("#other")).getAll("external_uploads[0][empty]")')[0]);

            $browser->press('Other Submit')->waitForText('external_uploads');
            $payload = json_decode($browser->script('return document.querySelector("pre")?.textContent ?? document.body.textContent')[0], true, 512, JSON_THROW_ON_ERROR);
            $this->assertSame([['files' => ['61'], 'empty' => '0']], $payload['external_uploads']);
            $this->assertArrayNotHasKey('locked_uploads', $payload);
            $this->assertArrayNotHasKey('uploads', $payload);
        });
    }

    public function testReadonlyAttachRejectsCustomRemoveAndUploadEvents(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitFixture($browser);
            $browser->script(<<<'JS'
window.fixtureUploadRequests = [];
const originalOpen = XMLHttpRequest.prototype.open;
XMLHttpRequest.prototype.open = function (method, url, ...args) {
    if (String(url).includes('/repeater/upload')) window.fixtureUploadRequests.push(String(url));
    return originalOpen.call(this, method, url, ...args);
};
const element = document.querySelector('[data-repeater-name="locked_uploads"] [data-controller="attach"]');
const fileInput = element.querySelector('[data-attach-target="files"]');
const files = new DataTransfer();
files.items.add(new File(['fixture'], 'forbidden.png', {type: 'image/png'}));
fileInput.files = files.files;
fileInput.dispatchEvent(new Event('change', {bubbles: true}));
element.dispatchEvent(new DragEvent('drop', {bubbles: true, cancelable: true, dataTransfer: files}));
element.querySelector('.pip button').dispatchEvent(new MouseEvent('click', {bubbles: true}));
JS);
            $this->assertSame([], $browser->script('return window.fixtureUploadRequests')[0]);
            $this->assertSame(['51'], $browser->script('return [...document.querySelectorAll(\'[data-repeater-name="locked_uploads"] .pip input\')].map(input => input.value)')[0]);
            $this->assertSame('51', $this->formValue($browser, 'locked_uploads[0][files][]'));
            $browser->press('Submit')->waitForText('locked_uploads');
            $payload = json_decode($browser->script('return document.querySelector("pre")?.textContent ?? document.body.textContent')[0], true, 512, JSON_THROW_ON_ERROR);
            $this->assertSame([['files' => ['51']]], $payload['locked_uploads']);
            $this->assertFalse(is_array($payload['external_uploads'] ?? null));
        });
    }

    public function testAddedAndReorderedAttachRowsUseTheirCurrentNames(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitFixture($browser);
            $browser->click('[data-repeater-name="uploads"] [data-action="repeater#addRow"]')
                ->waitUntil('document.querySelectorAll(\'[data-repeater-name="uploads"] [data-controller="attach"]\').length === 2');
            $browser->click('[data-repeater-name="uploads"] [data-repeater-row]:nth-child(2) [data-action="repeater#moveUp"]');
            $browser->waitUntil(<<<'JS'
[...document.querySelectorAll('[data-repeater-name="uploads"] [data-controller="attach"]')].every(element => window.application.getControllerForElementAndIdentifier(element, 'attach'))
JS);
            $browser->script(<<<'JS'
[...document.querySelectorAll('[data-repeater-name="uploads"] [data-controller="attach"]')].forEach((element, index) => {
    const controller = window.application.getControllerForElementAndIdentifier(element, 'attach');
    controller.renderPreview({id: 41 + index, url: '/favicon.ico', original_name: 'fixture.png', mime: 'image/png'});
});
JS);
            $this->assertSame('41', $this->formValue($browser, 'uploads[0][files][]'));
            $this->assertSame('42', $this->formValue($browser, 'uploads[1][files][]'));
            $browser->press('Submit')->waitForText('uploads');
            $payload = json_decode($browser->script('return document.querySelector("pre")?.textContent ?? document.body.textContent')[0], true, 512, JSON_THROW_ON_ERROR);
            $this->assertSame([['files' => ['41']], ['files' => ['42']]], $payload['uploads']);
        });
    }

    public function testReadonlyQuillAndNestedValuesRespectNativeFormOwnershipAndDisabledControls(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitFixture($browser);
            $this->assertSame('false', $browser->attribute('[data-repeater-name="locked"] .ql-editor', 'contenteditable'));
            $this->assertSame('<p>Read only</p>', $this->formValue($browser, 'locked[0][body]'));
            $this->assertSame('Nested value', $this->formValue($browser, 'locked[0][nested][0][title]'));
            $this->assertNull($this->formValue($browser, 'locked[0][excluded]'));
            $this->assertNull($this->formValue($browser, 'locked[0][external]'));
            $this->assertNull($this->formValue($browser, 'disabled[0][title]'));
            $this->assertSame(['other form value'], $browser->script('return new FormData(document.querySelector("#other")).getAll("locked[0][external]")')[0]);
            $this->assertSame(['Nested value'], $browser->script('return new FormData(document.querySelector("#fixture")).getAll("locked[0][nested][0][title]")')[0]);
            $browser->press('Submit')->waitForText('Read only');
            $payload = json_decode($browser->script('return document.querySelector("pre")?.textContent ?? document.body.textContent')[0], true, 512, JSON_THROW_ON_ERROR);
            $this->assertSame([['body' => '<p>Read only</p>', 'nested' => [['title' => 'Nested value']]]], $payload['locked']);
            $this->assertArrayNotHasKey('disabled', $payload);
        });
    }

    public function testSparseRetryHydratesBeforeReindexAndAllocatesUniqueIds(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/repeater/sparse')->waitUntil('window.application && document.querySelectorAll(\'[data-repeater-name="sparse"] input[name="sparse[0][name]"]\').length === 1');
            $this->assertSame('First', $this->formValue($browser, 'sparse[0][name]'));
            $this->assertSame('Second', $this->formValue($browser, 'sparse[1][name]'));
            $browser->click('[data-repeater-name="sparse"] [data-action="repeater#addRow"]');
            $browser->type('sparse[2][name]', 'Third');
            $this->assertTrue($browser->script(<<<'JS'
const ids = [...document.querySelectorAll('[data-repeater-name="sparse"] [id]')].map(element => element.id);
return new Set(ids).size === ids.length;
JS)[0]);
            $browser->press('Submit')->waitForText('Third');
            $payload = json_decode($browser->script('return document.querySelector("pre")?.textContent ?? document.body.textContent')[0], true, 512, JSON_THROW_ON_ERROR);
            $this->assertSame([['name' => 'First'], ['name' => 'Second'], ['name' => 'Third']], $payload['sparse']);
        });
    }

    public function testDateRangePairsStayIndependentAfterAddCloneAndReorder(): void
    {
        $this->browse(function (Browser $browser) {
            $this->visitFixture($browser);
            $this->assertSame('2026-10-10', $this->formValue($browser, 'periods[0][window][start]'));
            $this->assertSame('2026-10-12', $this->formValue($browser, 'periods[0][window][end]'));
            $browser->click('[data-repeater-name="periods"] [data-action="repeater#addRow"]');
            $browser->waitUntil(<<<'JS'
document.querySelectorAll('[data-repeater-name="periods"] [data-controller="datetime"]').length === 2 && [...document.querySelectorAll('[data-repeater-name="periods"] [data-controller="datetime"]')].every(element => window.application.getControllerForElementAndIdentifier(element, 'datetime'))
JS);
            $this->assertTrue($browser->script(<<<'JS'
return [...document.querySelectorAll('[data-repeater-name="periods"] [data-controller="datetime"]')].every(element => element.querySelector('input[name$="[end]"]') === document.querySelector(element.dataset.datetimeRange));
JS)[0]);
            $browser->click('[name="periods[1][window][start]"]');
            $browser->script(<<<'JS'
const element = document.querySelectorAll('[data-repeater-name="periods"] [data-controller="datetime"]')[1];
const controller = window.application.getControllerForElementAndIdentifier(element, 'datetime');
controller.fp.jumpToDate('2026-10-01');
JS);
            $browser->click('.flatpickr-calendar.open .flatpickr-day[aria-label="October 20, 2026"]')
                ->click('.flatpickr-calendar.open .flatpickr-day[aria-label="October 22, 2026"]');
            $this->assertSame('2026-10-20', $this->formValue($browser, 'periods[1][window][start]'));
            $this->assertSame('2026-10-22', $this->formValue($browser, 'periods[1][window][end]'));
            $browser->click('[data-repeater-name="periods"] [data-repeater-row]:nth-child(2) [data-repeater-clone]')
                ->waitUntil("document.querySelectorAll('[data-repeater-name=\"periods\"] [data-fp-omit]').length === 3");
            $browser->click('[data-repeater-name="periods"] [data-repeater-row]:nth-child(3) [data-action="repeater#moveUp"]');
            $browser->script(<<<'JS'
const element = document.querySelectorAll('[data-repeater-name="periods"] [data-controller="datetime"]')[1];
window.application.getControllerForElementAndIdentifier(element, 'datetime').fp.setDate(['2026-10-25', '2026-10-27'], true);
JS);
            $this->assertSame('2026-10-10', $this->formValue($browser, 'periods[0][window][start]'));
            $this->assertSame('2026-10-22', $this->formValue($browser, 'periods[2][window][end]'));
            $browser->press('Submit')->waitForText('periods');
            $payload = json_decode($browser->script('return document.querySelector("pre")?.textContent ?? document.body.textContent')[0], true, 512, JSON_THROW_ON_ERROR);
            $this->assertSame([
                ['window' => ['start' => '2026-10-10', 'end' => '2026-10-12']],
                ['window' => ['start' => '2026-10-25', 'end' => '2026-10-27']],
                ['window' => ['start' => '2026-10-20', 'end' => '2026-10-22']],
            ], $payload['periods']);
        });
    }

    private function visitFixture(Browser $browser): void
    {
        $browser->visit('/repeater')->waitUntil(<<<'JS'
window.application && document.querySelectorAll('.ql-editor').length === 2 && [...document.querySelectorAll('[data-controller="repeater"], [data-controller="attach"]')].every(element => window.application.getControllerForElementAndIdentifier(element, element.dataset.controller))
JS);
    }

    private function formValue(Browser $browser, string $name): ?string
    {
        $name = json_encode($name, JSON_THROW_ON_ERROR);

        return $browser->script('return new FormData(document.querySelector("#fixture")).get('.$name.')')[0];
    }
}
