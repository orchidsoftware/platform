<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use InvalidArgumentException;
use Orchid\Screen\Layouts\Chart;
use Orchid\Screen\Repository;
use Orchid\Support\Facades\Layout;
use Orchid\Tests\TestUnitCase;

class ChartTest extends TestUnitCase
{
    public function testChartCanBeConfiguredWithoutASubclass(): void
    {
        $chart = Layout::chart('visits', 'Visits')->height(300)->smooth()->gradient()
            ->dots(false)->legend(false)->colors(['#123456'])
            ->options(['strokeWidth' => 3]);

        $this->assertSame(Chart::class, $chart::class);
        $config = $chart->build($this->repository())->getData()['chart'];

        $this->assertSame('line', $config['type']);
        $this->assertSame([
            'height'      => 300,
            'colors'      => ['#123456'],
            'smooth'      => true,
            'gradient'    => true,
            'dots'        => false,
            'legend'      => false,
            'strokeWidth' => 3,
        ], $config['options']);
        $this->assertSame($this->repository()->get('visits'), $config['data']);
    }

    public function testOptionsMergeAndTheLastSettingWins(): void
    {
        $config = Chart::make('visits')->gradient()->height(300)
            ->options(['gradient' => false, 'height' => 280])->height(320)
            ->build($this->repository())->getData()['chart'];

        $this->assertFalse($config['options']['gradient']);
        $this->assertSame(320, $config['options']['height']);
        $this->assertNotEmpty($config['options']['colors']);
    }

    public function testDataKeepsLabelIdentityAndNumericValues(): void
    {
        $config = Chart::make('visits')->build(new Repository([
            'visits' => [
                'labels'   => [2 => '001', 4 => '001', 8 => '002'],
                'datasets' => [7 => ['name' => 'Visits', 'values' => [1 => '12.5', 4 => '0', 6 => '-3']]],
            ],
        ]))->getData()['chart'];

        $this->assertSame(['001', '001', '002'], $config['data']['labels']);
        $this->assertSame([['name' => 'Visits', 'values' => [12.5, 0, -3]]], $config['data']['datasets']);
    }

    public function testMixedDatasetsKeepTheirOwnPresentationOptions(): void
    {
        $data = [
            'labels'   => ['Mon', 'Tue'],
            'datasets' => [
                ['name' => 'Actual', 'chartType' => 'bar', 'values' => [12, 18], 'radius' => 3],
                ['name' => 'Plan', 'chartType' => 'line', 'values' => [15, 16], 'gradient' => false, 'smooth' => true],
            ],
        ];
        $config = Chart::make('visits')->type(Chart::TYPE_MIXED)
            ->build(new Repository(['visits' => $data]))->getData()['chart'];

        $this->assertSame('mixed', $config['type']);
        $this->assertSame($data, $config['data']);
    }

    public function testBarAndCompositionOptionsUseNativeNames(): void
    {
        $bar = Chart::make('visits')->type('bar')->stacked()->options(['horizontal' => true])
            ->build($this->repository())->getData()['chart'];
        $this->assertTrue($bar['options']['stacked']);
        $this->assertTrue($bar['options']['horizontal']);

        foreach (['pie', 'percentage'] as $type) {
            $config = Chart::make('visits')->type($type)->maxSlices(4)
                ->build($this->repository())->getData()['chart'];
            $this->assertSame(4, $config['options']['maxSlices']);
            $this->assertSame($this->repository()->get('visits'), $config['data']);
        }
    }

    public function testMarkerAndRegionDataReachTheChart(): void
    {
        $repository = $this->repository();
        $repository->set('visits.markers', [['label' => 'Minimum', 'value' => 5]]);
        $repository->set('visits.regions', [['label' => 'Range', 'range' => [5, 15]]]);
        $config = Chart::make('visits')->marker('Target', 20, ['lineStyle' => 'dashed'])
            ->build($repository)->getData()['chart'];

        $this->assertSame([
            ['label' => 'Minimum', 'value' => 5],
            ['label' => 'Target', 'value' => 20, 'lineStyle' => 'dashed'],
        ], $config['data']['markers']);
        $this->assertSame([['label' => 'Range', 'range' => [5, 15]]], $config['data']['regions']);
    }

    public function testGradientOpacityIsConfigurableFromPhp(): void
    {
        $gradient = ['fromOpacity' => 0.25, 'toOpacity' => 0.02];
        $config = Chart::make('visits')->gradient($gradient)
            ->build($this->repository())->getData()['chart'];

        $this->assertSame($gradient, $config['options']['gradient']);
    }

    public function testCompositionDoesNotSilentlyAggregateMultipleSeries(): void
    {
        $repository = $this->repository();
        $repository->set('visits.datasets.1', ['name' => 'Other', 'values' => [3, 4]]);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('exactly one dataset');
        Chart::make('visits')->type('pie')->build($repository);
    }

    public function testMissingDataReportsTheQueryKey(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Chart [missing] expects labels and datasets.');
        Chart::make('missing')->build($this->repository());
    }

    public function testEveryLabelRequiresAValue(): void
    {
        $repository = $this->repository();
        $repository->set('visits.datasets.0.values', [1]);
        $this->expectException(InvalidArgumentException::class);
        Chart::make('visits')->build($repository);
    }

    public function testUnsupportedTypeIsRejected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Chart::make('visits')->type('axis-mixed');
    }

    public function testIncompatibleOptionsAreRejectedInPhp(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported bar chart option: gradient');
        Chart::make('visits')->type('bar')->gradient()->build($this->repository());
    }

    public function testHiddenChartDoesNotRequireData(): void
    {
        $this->assertNull(Chart::make('missing')->canSee(false)->build(new Repository));
    }

    public function testBladeEscapesTheSingleConfigurationAndTogglesExport(): void
    {
        $repository = $this->repository();
        $repository->set('visits.labels', ['" onmouseover="alert(1)', '<script>']);
        $chart = Chart::make('visits', 'Visits')->export();
        $html = $chart->build($repository)->withErrors([])->render();
        $this->assertStringContainsString('data-action="chart#export"', $html);
        $this->assertStringNotContainsString('<script>', $html);
        preg_match('/data-chart-config-value="([^"]*)"/', $html, $matches);
        $config = json_decode(html_entity_decode($matches[1], ENT_QUOTES), true, flags: JSON_THROW_ON_ERROR);
        $this->assertSame($repository->get('visits'), $config['data']);

        $html = $chart->export(false)->build($repository)->withErrors([])->render();
        $this->assertStringNotContainsString('data-action="chart#export"', $html);
    }

    private function repository(): Repository
    {
        return new Repository([
            'visits' => [
                'labels'   => ['Mon', 'Tue'],
                'datasets' => [['name' => 'Visits', 'values' => [12, 18]]],
            ],
        ]);
    }
}
