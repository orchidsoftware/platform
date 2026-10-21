<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use DOMDocument;
use DOMXPath;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\NumberRange;
use Orchid\Screen\Fields\RadioButtons;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

class BootstrapMarkupTest extends TestFieldsUnitCase
{
    public function testRangeLabelsTargetPopulatedControlsWithoutDuplicateAttributes(): void
    {
        foreach ([
            DateRange::make('period')->value(['start' => '2026-10-10', 'end' => '2026-10-12']),
            NumberRange::make('price')->value(['min' => 10, 'max' => 20]),
        ] as $field) {
            $html = self::renderField($field->form('order'));
            $xpath = $this->xpath($html);
            $inputs = $xpath->query('//input');
            $this->assertCount(2, $inputs);
            foreach ($inputs as $input) {
                $this->assertNotEmpty($input->getAttribute('value'));
                $this->assertSame('order', $input->getAttribute('form'));
                $this->assertCount(1, $xpath->query('//label[@for="'.$input->getAttribute('id').'"]'));
            }
            preg_match_all('/<input\b[^>]*>/s', $html, $tags);
            foreach ($tags[0] as $tag) {
                foreach (['name', 'id', 'value'] as $attribute) {
                    $this->assertSame(1, preg_match_all('/\s'.$attribute.'\s*=/', $tag));
                }
            }
        }
    }

    public function testClearIsANativeButtonAndRespectsReadOnlyAndDisabledFields(): void
    {
        foreach ([[], ['readonly' => true], ['disabled' => true]] as $state) {
            $field = DateTimer::make('appointment')->allowEmpty();
            foreach ($state as $key => $value) {
                $field->set($key, $value);
            }
            $xpath = $this->xpath(self::renderField($field));
            $button = $xpath->query('//button[@data-action="datetime#clear"]')->item(0);
            $this->assertNotNull($button);
            $this->assertSame('button', $button->getAttribute('type'));
            $this->assertNotEmpty($button->getAttribute('aria-label'));
            $this->assertSame($state !== [], $button->hasAttribute('disabled'));
        }
    }

    public function testMatrixHasMatchingColumnsAndASeparateRowTemplate(): void
    {
        foreach ([true, false] as $removable) {
            $xpath = $this->xpath(self::renderField(Matrix::make('items')->columns(['Name' => 'name'])
                ->removableRows($removable)->value([['name' => 'Existing']])));
            $columns = $removable ? 2 : 1;
            $this->assertCount($columns, $xpath->query('//table/thead/tr/th'));
            $this->assertCount($columns, $xpath->query('//table/tbody/tr[1]/td'));
            $this->assertSame((string) $columns, $xpath->query('//tr[@class="add-row"]/th')->item(0)->getAttribute('colspan'));
            $this->assertCount(0, $xpath->query('//table//template'));
            $this->assertCount(1, $xpath->query('//template'));
            $this->assertCount(1, $xpath->query('//button[@type="button" and @data-action="matrix#addRow"]'));
        }
    }

    public function testRadioButtonsUseNativeLabelTargetsAndKeepTheSelectedValue(): void
    {
        $xpath = $this->xpath(self::renderField(RadioButtons::make('status')
            ->options(['draft' => 'Draft', 'published' => 'Published'])->value('published')->form('order')));
        $this->assertCount(2, $xpath->query('//input[@type="radio"]'));
        $this->assertSame('published', $xpath->query('//input[@checked]')->item(0)->getAttribute('value'));
        foreach ($xpath->query('//input[@type="radio"]') as $input) {
            $this->assertSame('order', $input->getAttribute('form'));
            $this->assertCount(1, $xpath->query('//label[@for="'.$input->getAttribute('id').'"]'));
        }
    }

    private function xpath(string $html): DOMXPath
    {
        $document = new DOMDocument;
        @$document->loadHTML($html);

        return new DOMXPath($document);
    }
}
