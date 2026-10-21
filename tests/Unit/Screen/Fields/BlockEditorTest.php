<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Orchid\Screen\Fields\BlockEditor;
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
}
