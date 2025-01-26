<?php

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Split;
use Orchid\Screen\Repository;
use Orchid\Support\Facades\Layout;
use Orchid\Tests\TestUnitCase;

class SplitTest extends TestUnitCase
{
    public function test_base(): void
    {
        $layout = $this->getSplitClass([
            Layout::rows([Input::make('first')]),
            Layout::rows([Input::make('last')]),
        ]);

        $html = $layout->build(new Repository);

        $this->assertStringContainsString('col-md-6 order-md-first', $html);
        $this->assertStringContainsString('col-md-6 order-md-last', $html);
    }

    public function test_ratio(): void
    {
        $layout = $this->getSplitClass([
            Layout::rows([Input::make('first')]),
            Layout::rows([Input::make('last')]),
        ])->ratio('20/80');

        $html = $layout->build(new Repository);

        $this->assertStringContainsString('col-md-2 order-md-first', $html);
        $this->assertStringContainsString('col-md-10 order-md-last', $html);
    }

    public function test_ratio_invalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $layout = $this->getSplitClass([
            Layout::rows([Input::make('first')]),
            Layout::rows([Input::make('last')]),
        ])->ratio('5/96');

        $layout->build(new Repository);
    }

    public function test_reverse_on_phone(): void
    {
        $layout = $this->getSplitClass([
            Layout::rows([Input::make('first')]),
            Layout::rows([Input::make('last')]),
        ])->ratio('20/80')->reverseOnPhone();

        $html = $layout->build(new Repository);

        $this->assertStringContainsString('col-md-2 order-md-first', $html);
        $this->assertStringContainsString('col-md col-md-10 order-md-last order-first', $html);
    }

    /**
     * @param $layouts
     *
     * @return \Orchid\Screen\Layouts\Split
     */
    private function getSplitClass($layouts): Split
    {
        return new class($layouts) extends Split {};
    }
}
