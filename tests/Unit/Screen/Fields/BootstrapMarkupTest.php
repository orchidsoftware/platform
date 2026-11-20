<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

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
            $inputs = $this->elements($xpath, '//input');
            $this->assertCount(2, $inputs);
            foreach ($inputs as $input) {
                $this->assertNotEmpty($input->getAttribute('value'));
                $this->assertSame('order', $input->getAttribute('form'));
                $this->assertCount(1, $this->elements($xpath, '//label[@for="'.$input->getAttribute('id').'"]'));
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
            $button = $this->firstElement($xpath, '//button[@data-action="datetime#clear"]');

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
            $this->assertCount($columns, $this->elements($xpath, '//table/thead/tr/th'));
            $this->assertCount($columns, $this->elements($xpath, '//table/tbody/tr[1]/td'));
            $this->assertSame((string) $columns, $this->firstElement($xpath, '//tr[@class="add-row"]/th')->getAttribute('colspan'));
            $this->assertCount(0, $this->elements($xpath, '//table//template'));
            $this->assertCount(1, $this->elements($xpath, '//template'));
            $this->assertCount(1, $this->elements($xpath, '//button[@type="button" and @data-action="matrix#addRow"]'));
        }
    }

    public function testRadioButtonsUseNativeLabelTargetsAndKeepTheSelectedValue(): void
    {
        $xpath = $this->xpath(self::renderField(RadioButtons::make('status')
            ->options(['draft' => 'Draft', 'published' => 'Published'])->value('published')->form('order')));
        $this->assertCount(2, $this->elements($xpath, '//input[@type="radio"]'));
        $this->assertSame('published', $this->firstElement($xpath, '//input[@checked]')->getAttribute('value'));
        foreach ($this->elements($xpath, '//input[@type="radio"]') as $input) {
            $this->assertSame('order', $input->getAttribute('form'));
            $this->assertCount(1, $this->elements($xpath, '//label[@for="'.$input->getAttribute('id').'"]'));
        }
    }
}
