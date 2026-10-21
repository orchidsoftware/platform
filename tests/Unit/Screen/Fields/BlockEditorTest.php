<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Builder;
use Orchid\Screen\Fields\BlockEditor;
use Orchid\Screen\Repository;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

class BlockEditorTest extends TestFieldsUnitCase
{
    public function testDefaultToolbar(): void
    {
        $view = self::minifyRenderField(BlockEditor::make('content'));

        $this->assertStringContainsString('data-controller="block-editor"', $view);
        $this->assertStringContainsString('"type":"paragraph"', $view);
        $this->assertStringContainsString('"type":"heading"', $view);
        $this->assertStringContainsString('"type":"quote"', $view);
        $this->assertStringContainsString('"type":"list"', $view);
        $this->assertStringContainsString('"type":"image"', $view);
        $this->assertStringContainsString('"type":"code"', $view);
        $this->assertStringContainsString('"type":"embed"', $view);
        $this->assertStringNotContainsString('role="toolbar"', $view);
    }

    public function testToolbarCanBeCustomized(): void
    {
        $view = self::minifyRenderField(
            BlockEditor::make('content')->toolbar([
                BlockEditor::HEADING,
                BlockEditor::IMAGE,
            ])
        );

        $this->assertStringContainsString('"type":"heading"', $view);
        $this->assertStringContainsString('"type":"image"', $view);
        $this->assertStringNotContainsString('"type":"paragraph"', $view);
        $this->assertStringNotContainsString('"type":"list"', $view);
        $this->assertStringNotContainsString('"type":"code"', $view);
    }

    public function testToolbarCanBeHidden(): void
    {
        $view = self::minifyRenderField(
            BlockEditor::make('content')->withoutToolbar()
        );

        $this->assertStringContainsString('data-block-editor-tools-value=\'[]\'', $view);
        $this->assertStringNotContainsString('"type":"paragraph"', $view);
        $this->assertStringNotContainsString('role="toolbar"', $view);
    }

    public function testArrayValueIsEncodedAsJson(): void
    {
        $view = self::minifyRenderField(
            BlockEditor::make('content')->value([
                'blocks' => [
                    ['type' => 'paragraph', 'text' => 'Hello'],
                ],
            ])
        );

        $this->assertStringContainsString(
            '{&quot;blocks&quot;:[{&quot;type&quot;:&quot;paragraph&quot;,&quot;text&quot;:&quot;Hello&quot;}]}',
            $view
        );
    }

    public function testToolbarPreservesConfiguredOrderAndFiltersUnknownButtons(): void
    {
        $view = self::minifyRenderField(BlockEditor::make('content')->toolbar([
            BlockEditor::CODE, 'unsupported', BlockEditor::HEADING, BlockEditor::CODE,
        ]));

        $this->assertStringContainsString(
            'data-block-editor-tools-value=\'[{"type":"code","title":"Code"},{"type":"heading","title":"Heading"}]\'',
            $view
        );
    }

    public function testJsonObjectsRetainTheirMetadata(): void
    {
        $value = (object) ['version' => 3, 'blocks' => [(object) ['type' => 'code', 'code' => '</textarea><script>unsafe</script>']]];
        $view = self::minifyRenderField(BlockEditor::make('content')->value($value));

        $this->assertStringContainsString('&quot;version&quot;:3', $view);
        $this->assertStringContainsString('&lt;/textarea&gt;&lt;script&gt;unsafe&lt;/script&gt;', $view);
        $this->assertStringNotContainsString('<script>unsafe</script>', $view);
    }

    public function testMalformedJsonIsPreservedForTheClient(): void
    {
        $view = self::minifyRenderField(BlockEditor::make('content')->value('{malformed'));

        $this->assertStringContainsString('>{malformed</textarea>', $view);
    }

    public function testLockedFieldAttributesAreRendered(): void
    {
        $view = self::minifyRenderField(BlockEditor::make('content')->readonly()->disabled()->name('article[body]'));

        $this->assertStringContainsString('data-block-editor-readonly-value=\'true\'', $view);
        $this->assertStringContainsString('data-block-editor-disabled-value=\'true\'', $view);
        $this->assertStringContainsString('name="article[body]"', $view);
        $this->assertStringContainsString('readonly', $view);
        $this->assertStringContainsString('disabled', $view);
    }

    public function testClearedOldInputOverridesPersistedContent(): void
    {
        $this->registerValidationRoutes();

        foreach (['', null] as $value) {
            $this->from('/block-editor')->post('/block-editor', ['body' => $value])
                ->assertRedirect('/block-editor')
                ->assertSessionHasErrors('required');

            $this->assertNull(session()->getOldInput('body'));
            $this->assertTrue(array_key_exists('body', session()->getOldInput()));
            $this->assertDocument('{"blocks":[]}');
        }
    }

    public function testAbsentOldInputKeepsPersistedContent(): void
    {
        $this->registerValidationRoutes();

        $this->from('/block-editor')->post('/block-editor', [])
            ->assertRedirect('/block-editor');

        $this->assertDocument('{"blocks":[{"type":"paragraph","text":"Persisted content"}]}');
    }

    public function testNestedPrefixedOldInputCanClearPersistedContent(): void
    {
        $this->registerValidationRoutes('article.body', 'settings');

        $this->from('/block-editor')->post('/block-editor', [
            'settings' => ['article' => ['body' => '']],
        ])->assertRedirect('/block-editor');

        $this->assertDocument('{"blocks":[]}');
    }

    public function testInvalidAndUnknownOldDocumentsArePreserved(): void
    {
        $this->registerValidationRoutes();

        foreach (['{malformed', '{"version":9,"blocks":[{"type":"future","custom":"Keep me"}]}'] as $document) {
            $this->from('/block-editor')->post('/block-editor', ['body' => $document])
                ->assertRedirect('/block-editor');

            $this->assertDocument($document);
        }
    }

    private function assertDocument(string $expected): void
    {
        $response = $this->get('/block-editor')->assertOk();
        $document = new \DOMDocument;
        @$document->loadHTML($response->getContent());
        $xpath = new \DOMXPath($document);
        $textarea = $xpath->query('//textarea[@data-block-editor-target="textarea"]')->item(0);

        $this->assertNotNull($textarea);
        $this->assertSame($expected, trim($textarea->textContent));
    }

    private function registerValidationRoutes(string $name = 'body', ?string $prefix = null): void
    {
        $path = $prefix === null ? $name : $prefix.'.'.$name;

        Route::middleware(['web', ConvertEmptyStringsToNull::class])->group(function () use ($name, $prefix, $path) {
            Route::post('/block-editor', function (Request $request) use ($path) {
                $request->validate([
                    $path      => ['nullable', 'json'],
                    'required' => ['required'],
                ]);
            });

            Route::get('/block-editor', function () use ($name, $prefix, $path) {
                $data = [];
                data_set($data, $path, '{"blocks":[{"type":"paragraph","text":"Persisted content"}]}');
                $repository = new Repository($data);
                $oldInput = session()->getOldInput();
                $errors = session('errors');
                $view = (new Builder([BlockEditor::make($name)], $repository))
                    ->setPrefix($prefix)
                    ->generateForm();

                $this->assertSame($data, $repository->toArray());
                $this->assertSame($oldInput, session()->getOldInput());
                $this->assertSame($errors, session('errors'));

                return $view;
            });
        });
    }
}
