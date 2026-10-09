<?php

declare(strict_types=1);

namespace Orchid\Tests\Console;

use Illuminate\Support\Str;
use Orchid\Screen\Repository;
use Orchid\Tests\TestConsoleCase;

class ChartCommandTest extends TestConsoleCase
{
    public function testGeneratedChartCanBeLoadedAndConfigured(): void
    {
        $name = 'Chart'.Str::random();

        $this->artisan('orchid:chart', ['name' => $name])->assertOk();

        require app_path('Orchid/Layouts/'.$name.'.php');

        $class = 'App\\Orchid\\Layouts\\'.$name;
        $view = $class::make('visits')->height(300)->build(new Repository([
            'visits' => [
                'labels'   => ['Mon', 'Tue'],
                'datasets' => [['name' => 'Visits', 'values' => [12, 18]]],
            ],
        ]));

        $this->assertSame('bar', $view->getData()['chart']['type']);
        $this->assertSame(300, $view->getData()['height']);
        $this->assertTrue($view->getData()['export']);
    }
}
