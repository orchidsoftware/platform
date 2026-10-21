<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Orchid\Screen\Builder;
use Orchid\Screen\Fields\KeyValue;
use Orchid\Screen\Repository;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

class KeyValueTest extends TestFieldsUnitCase
{
    public function testValue(): void
    {
        $field = KeyValue::make('meta')
            ->value([
                'title' => 'Hello',
                'color' => '#ffffff',
            ]);

        $view = self::minifyRenderField($field);

        $this->assertStringContainsString('name="meta[0][key]"', $view);
        $this->assertStringContainsString('value="title"', $view);
        $this->assertStringContainsString('name="meta[0][value]"', $view);
        $this->assertStringContainsString('value="Hello"', $view);
        $this->assertStringContainsString('value="#ffffff"', $view);
    }

    public function testLabelsAndPlaceholders(): void
    {
        $field = KeyValue::make('meta')
            ->keyLabel('Property')
            ->valueLabel('Content')
            ->keyPlaceholder('Property name')
            ->valuePlaceholder('Property value');

        $view = self::minifyRenderField($field);

        $this->assertStringContainsString('Property', $view);
        $this->assertStringContainsString('Content', $view);
        $this->assertStringContainsString('placeholder="Property name"', $view);
        $this->assertStringContainsString('placeholder="Property value"', $view);
    }

    public function testDisabledActionsAndInputs(): void
    {
        $field = KeyValue::make('meta')
            ->addable(false)
            ->deletable(false)
            ->editableKeys(false)
            ->editableValues(false)
            ->value(['title' => 'Hello']);

        $view = self::minifyRenderField($field);

        $this->assertStringNotContainsString('data-action="key-value#addRow"', $view);
        $this->assertStringNotContainsString('data-action="key-value#deleteRow"', $view);
        $this->assertStringContainsString('readonly', $view);
        $this->assertStringNotContainsString('readonly disabled', $view);
    }

    public function testReorderable(): void
    {
        $field = KeyValue::make('meta')
            ->reorderable()
            ->value(['title' => 'Hello']);

        $view = self::minifyRenderField($field);

        $this->assertStringContainsString('data-action="key-value#moveUp"', $view);
        $this->assertStringContainsString('data-action="key-value#moveDown"', $view);
    }

    public function testRowsToArray(): void
    {
        $this->assertSame([
            'title' => 'Hello',
            'color' => '#ffffff',
        ], KeyValue::rowsToArray([
            ['key' => 'title', 'value' => 'Hello'],
            ['key' => '', 'value' => 'Ignored'],
            ['key' => 'color', 'value' => '#ffffff'],
        ]));
    }

    public function testRepositoryHydrationPreservesMapKeysAndNestedName(): void
    {
        $field = KeyValue::make('settings.meta');
        $view = (new Builder([$field], new Repository([
            'settings' => ['meta' => ['key' => 'Literal key', 'value' => 'Literal value']],
        ])))->generateForm();

        $this->assertSame([
            ['key' => 'key', 'value' => 'Literal key'],
            ['key' => 'value', 'value' => 'Literal value'],
        ], $field->get('value'));
        $this->assertStringContainsString('name="settings[meta][1][value]"', $view);
        $this->assertStringContainsString('data-key-value-name-value="settings[meta]"', $view);
    }

    public function testOldInputWinsOverRepositoryAndReindexesSparseRows(): void
    {
        session()->flashInput(['meta' => [7 => ['key' => 'draft', 'value' => 'Saved input']]]);
        request()->setLaravelSession(session()->driver());
        $field = KeyValue::make('meta');
        $view = (new Builder([$field], new Repository(['meta' => ['title' => 'Original']])))->generateForm();

        $this->assertSame([['key' => 'draft', 'value' => 'Saved input']], $field->get('value'));
        $this->assertStringContainsString('name="meta[0][value]"', $view);
        $this->assertStringNotContainsString('Original', $view);
    }

    public function testClosureAndNullValuesAreNormalizedAtRender(): void
    {
        $field = KeyValue::make('meta')->value(fn () => ['zero' => 0, 'empty' => null]);
        $field->render();
        $this->assertSame([
            ['key' => 'zero', 'value' => 0],
            ['key' => 'empty', 'value' => null],
        ], $field->get('value'));

        $empty = KeyValue::make('meta')->value(null);
        $view = $empty->render()->render();
        $this->assertSame([], $empty->get('value'));
        $this->assertStringContainsString('data-key-value-target="empty"', $view);
    }

    public function testReadonlyRetainsControlsAndLocksActions(): void
    {
        $view = self::minifyRenderField(KeyValue::make('meta')->readonly()->reorderable()->value(['a' => 'b']));

        $this->assertStringContainsString('readonly', $view);
        $this->assertStringContainsString('name="meta[0][key]" value="a"', $view);
        $this->assertStringNotContainsString('data-action="key-value#', $view);
    }

    public function testDisabledUsesNativeDisabledControlsAndLocksActions(): void
    {
        $view = self::minifyRenderField(KeyValue::make('meta')->disabled()->reorderable()->value(['a' => 'b']));

        $this->assertStringContainsString('data-key-value-disabled-value="true"', $view);
        $this->assertMatchesRegularExpression('/data-key-value-cell="key"[^>]*disabled/', $view);
        $this->assertStringNotContainsString('data-action="key-value#', $view);
    }

    public function testRowsAreEscapedAndConversionHandlesDuplicateAndZeroKeys(): void
    {
        $view = self::minifyRenderField(KeyValue::make('meta')->value([
            ['key' => '<script>', 'value' => '\" onfocus=alert(1)'],
        ]));
        $this->assertStringContainsString('&lt;script&gt;', $view);
        $this->assertStringNotContainsString('value="<script>', $view);
        $this->assertSame([0 => 'zero', 'same' => 'last'], KeyValue::rowsToArray([
            ['key' => '', 'value' => 'ignored'],
            ['key' => '0', 'value' => 'zero'],
            ['key' => 'same', 'value' => 'first'],
            ['key' => 'same', 'value' => 'last'],
        ]));
        $this->assertSame([], KeyValue::rowsToArray([['key' => '', 'value' => '']]));
    }

    public function testRenderingTwiceKeepsRowsStable(): void
    {
        $field = KeyValue::make('meta')->value(['one' => '1', 'two' => null]);
        $field->render();
        $rows = $field->get('value');
        $field->render();
        $this->assertSame($rows, $field->get('value'));
    }

    public function testExternalFormAssociationIncludesRowsTemplateAndEmptySentinels(): void
    {
        $view = self::renderField(KeyValue::make('meta')->form('external')->value(['one' => '1']));
        $document = new \DOMDocument;
        @$document->loadHTML($view);
        $xpath = new \DOMXPath($document);
        $inputs = $xpath->query('//input[@name]');
        $this->assertSame(6, $inputs->length);
        foreach ($inputs as $input) {
            $this->assertSame('external', $input->getAttribute('form'));
        }
    }
}
