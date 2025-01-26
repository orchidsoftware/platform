<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Repository;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

/**
 * Class DropDownTest.
 */
class DropDownTest extends TestFieldsUnitCase
{
    public function test_drop_down_instance(): void
    {
        $dropDown = DropDown::make('About');
        $view = self::renderField($dropDown);

        $this->assertStringContainsString('About', $view);
    }

    public function test_drop_down_title(): void
    {
        $dropDown = DropDown::make('About')
            ->title('Please click to open');

        $view = self::renderField($dropDown);

        $this->assertStringContainsString('Please click to open', $view);
    }

    public function test_drop_down_list_title(): void
    {
        $view = DropDown::make('About')
            ->title('Please click to open')
            ->list([
                Link::make('Item 1')->href('link-1'),
                Link::make('Item 2')->href('link-2'),
            ])
            ->build(new Repository)
            ->render();

        $this->assertStringContainsString('Item 1', $view);
        $this->assertStringContainsString('Item 2', $view);
        $this->assertStringContainsString('link-1', $view);
        $this->assertStringContainsString('link-2', $view);
    }
}
