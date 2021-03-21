<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

class MatrixTest extends TestFieldsUnitCase
{
    public function testColumns(): void
    {
        $matrix = Matrix::make('matrix')
            ->columns([
                'Attribute',
                'Value',
                'Units',
            ]);

        $view = self::minifyRenderField($matrix);

        $this->assertStringContainsString('Attribute', $view);
        $this->assertStringContainsString('Value', $view);
        $this->assertStringContainsString('Units', $view);
    }

    public function testColumnsAlias(): void
    {
        $matrix = Matrix::make('matrix')
            ->columns([
                'attribute' => 'Attr',
                'value'     => 'Values',
                'units'     => 'United',
            ]);

        $view = self::renderField($matrix);

        $this->assertStringContainsString('Values', $view);
        $this->assertStringContainsString('United', $view);
    }

    public function testColumnsValue(): void
    {
        $matrix = Matrix::make('matrix')
            ->columns([
                'attribute',
                'value',
                'units',
            ])
            ->value([
                [
                    'attribute' => 'color',
                    'value'     => '#ffffff',
                    'units'     => 'rgb',
                ],
            ]);

        $view = self::renderField($matrix);

        $this->assertStringContainsString('color', $view);
        $this->assertStringContainsString('#ffffff', $view);
        $this->assertStringContainsString('rgb', $view);
    }

    public function testColumnsField(): void
    {
        $matrix = Matrix::make('matrix')
            ->columns([
                'attribute',
                'value',
                'units',
            ])
            ->fields([
                'attribute' => Input::make(),
            ])
            ->value([
                [
                    'attribute' => 'color',
                    'value'     => '#ffffff',
                    'units'     => 'rgb',
                ],
            ]);

        $view = self::minifyRenderField($matrix);
        $input = self::minifyRenderField(
            Input::make('matrix[0][attribute]')
                ->value('color')
                ->id('matrix-field-matrix-0-attribute')
        );

        $this->assertStringContainsString($input, $view);
    }
}
