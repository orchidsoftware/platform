<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Layouts\Chart;
use Orchid\Screen\Repository;
use Orchid\Tests\TestUnitCase;

class ChartTest extends TestUnitCase
{
    public function testDisabledExportButton(): void
    {
        $layout = new class extends Chart
        {
            /**
             * @var string
             */
            protected $target = 'charts';

            /**
             * Determines whether to display the export button.
             *
             * @var bool
             */
            protected $export = false;
        };

        $html = $layout
            ->build($this->getRepository())
            ->withErrors([])
            ->render();

        $this->assertStringNotContainsString('Export', $html);
    }

    public function testEnabledExportButton(): void
    {
        $layout = new class extends Chart
        {
            /**
             * @var string
             */
            protected $target = 'charts';
        };

        $html = $layout
            ->build($this->getRepository())
            ->withErrors([])
            ->render();

        $this->assertStringContainsString('Export', $html);
    }

    protected function getRepository(): Repository
    {
        return new Repository([
            'charts' => [
                [
                    'labels' => ['12am-3am', '3am-6am', '6am-9am', '9am-12pm', '12pm-3pm', '3pm-6pm', '6pm-9pm'],
                    'title'  => 'Some Data',
                    'values' => [25, 40, 30, 35, 8, 52, 17, -4],
                ],
                [
                    'labels' => ['12am-3am', '3am-6am', '6am-9am', '9am-12pm', '12pm-3pm', '3pm-6pm', '6pm-9pm'],
                    'title'  => 'Another Set',
                    'values' => [25, 50, -10, 15, 18, 32, 27, 14],
                ],
                [
                    'labels' => ['12am-3am', '3am-6am', '6am-9am', '9am-12pm', '12pm-3pm', '3pm-6pm', '6pm-9pm'],
                    'title'  => 'Yet Another',
                    'values' => [15, 20, -3, -15, 58, 12, -17, 37],
                ],
            ],
        ]);
    }
}
