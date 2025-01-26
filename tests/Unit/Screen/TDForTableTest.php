<?php

namespace Orchid\Tests\Unit\Screen;

use Orchid\Screen\Repository;
use Orchid\Screen\TD;
use Orchid\Tests\TestUnitCase;

class TDForTableTest extends TestUnitCase
{
    public function test_show_popover(): void
    {
        $popover = 'Vivamus sagittis lacus vel augue laoreet rutrum faucibus.';

        $view = TD::make('name')->popover($popover)->buildTh();

        $this->assertStringContainsString($popover, $view);
    }

    public function test_td_width(): void
    {
        $width = '100px';

        $view = TD::make('name')->width($width)->buildTd(new Repository(['name' => 'value']));

        $this->assertStringContainsString('style="min-width:'.$width.'', $view);
    }

    public function test_td_style(): void
    {
        $style = 'border-color: red;';

        $view = TD::make('name')->style($style)->buildTd(new Repository(['name' => 'value']));

        $this->assertStringContainsString('style="'.$style.'', $view);
    }

    public function test_td_class(): void
    {
        $class = 'my-custom-class';

        $view = TD::make('name')->class($class)->buildTd(new Repository(['name' => 'value']));

        $this->assertStringContainsString('text-start  text-truncate  '.$class.'', $view);
    }

    public function test_td_width_with_custom_style(): void
    {
        $width = '100px';
        $style = 'border-color: red;';

        $view = TD::make('name')->width($width)->style($style)->buildTd(new Repository(['name' => 'value']));

        $this->assertStringContainsString('style="min-width:'.$width.'; '.$style.'', $view);
    }

    public function test_td_without_width(): void
    {
        $view = TD::make('name')->buildTd(new Repository(['name' => 'value']));

        $this->assertStringNotContainsString('style="min-width:"', $view);
    }

    public function test_td_width_numeric(): void
    {
        $integer = 100;

        $view = TD::make('name')->width($integer)->buildTd(new Repository(['name' => 'value']));

        $this->assertStringContainsString('style="min-width:'.$integer.'px', $view);

        $float = 100.51;

        $view = TD::make('name')->width($float)->buildTd(new Repository(['name' => 'value']));

        $this->assertStringContainsString('style="min-width:'.$float.'px', $view);
    }

    public function test_td_width_string(): void
    {
        $stringWithInteger = '100';

        $view = TD::make('name')->width($stringWithInteger)->buildTd(new Repository(['name' => 'value']));

        $this->assertStringContainsString('style="min-width:'.$stringWithInteger.'px', $view);

        $stringWithFloat = '100.50';

        $view = TD::make('name')->width($stringWithFloat)->buildTd(new Repository(['name' => 'value']));

        $this->assertStringContainsString('style="min-width:'.$stringWithFloat.'px', $view);

        $stringWithNotOnlyNumeric = '100em';

        $view = TD::make('name')->width($stringWithNotOnlyNumeric)->buildTd(new Repository(['name' => 'value']));

        $this->assertStringContainsString('style="min-width:'.$stringWithNotOnlyNumeric, $view);
    }

    public function test_td_alight(): void
    {
        $view = TD::make('name')->alignLeft()->buildTd(new Repository(['name' => 'value']));
        $this->assertStringContainsString('class="text-'.TD::ALIGN_LEFT, $view);

        $view = TD::make('name')->alignRight()->buildTd(new Repository(['name' => 'value']));
        $this->assertStringContainsString('class="text-'.TD::ALIGN_RIGHT, $view);

        $view = TD::make('name')->alignCenter()->buildTd(new Repository(['name' => 'value']));
        $this->assertStringContainsString('class="text-'.TD::ALIGN_CENTER, $view);
    }
}
