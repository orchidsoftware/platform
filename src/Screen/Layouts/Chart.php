<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Chart.
 */
abstract class Chart extends Layout
{
    public const TYPE_BAR = 'bar';
    public const TYPE_LINE = 'line';
    public const TYPE_PIE = 'pie';
    public const TYPE_PERCENTAGE = 'percentage';
    public const TYPE_AXIS_MIXED = 'axis-mixed';

    /**
     * The Main template to display the layer
     * Represents the view() argument.
     *
     * @var string
     */
    protected $template = 'orchid::layouts.chart';

    /**
     * @var string|null
     */
    protected $description;

    /**
     * Add a title to the Chart.
     *
     * @var string
     */
    protected $title = 'My Chart';

    /**
     * Available options:
     * 'bar', 'line', 'pie',
     * 'percentage', 'axis-mixed'.
     *
     * @var string
     */
    protected $type = self::TYPE_LINE;

    /**
     * Height of the chart.
     *
     * @var int
     */
    protected $height = 250;

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the chart.
     *
     * @var string
     */
    protected $target = '';

    /**
     * Colors used.
     *
     * @var array
     */
    protected $colors = [
        '#2ec7c9', '#b6a2de', '#5ab1ef', '#ffb980', '#d87a80',
        '#8d98b3', '#e5cf0d', '#97b552', '#95706d', '#dc69aa',
        '#07a2a4', '#9a7fd1', '#588dd5', '#f5994e', '#c05050',
        '#59678c', '#c9ab00', '#7eb00a', '#6f5553', '#c14089',
    ];

    /**
     * Determines whether to display the export button.
     *
     * @var bool
     */
    protected $export = false;

    /**
     * Limiting the slices.
     *
     * When there are too many data values to show visually,
     * it makes sense to bundle up the least of the values as a cumulated data point,
     * rather than showing tiny slices.
     *
     * @var int
     */
    protected $maxSlices = 6;

    /**
     * To display data values over bars or dots in an axis graph.
     *
     * @var int
     */
    protected $valuesOverPoints = 0;

    /**
     * Configuring bar stacking.
     *
     * @var array
     */
    protected $barOptions = [
        'stacked' => 0,
    ];

    /**
     * Configuring line.
     *
     * @var array
     */
    protected $lineOptions = [
        'regionFill' => 0,
        'hideDots'   => 0,
        'hideLine'   => 0,
        'dotSize'    => 4,
        'spline'     => 0,
    ];

    /**
     * To highlight certain values on the Y axis, markers can be set.
     * They will show as dashed lines on the graph.
     */
    protected function markers(): ?array
    {
        return null;
    }

    /**
     * Create a new Charts element.
     *
     * @return static
     */
    public static function make(string $target, ?string $title = null): self
    {
        return (new static)->target($target)->title($title);
    }

    /**
     * @return $this
     */
    public function target(string $target): static
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Set title of the chart.
     *
     * @return $this
     */
    public function title(?string $title = null): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set description of the chart.
     *
     * @return $this
     */
    public function description(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Set the height of the chart.
     *
     * @return $this
     */
    public function height(int $height): static
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function type(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param bool $export
     *
     * @return $this
     */
    public function export(bool $export = true): static
    {
        $this->export = $export;

        return $this;
    }

    /**
     * @return Factory|View
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return;
        }

        $labels = collect($repository->getContent($this->target))
            ->map(fn ($item) => $item['labels'] ?? [])
            ->flatten()
            ->unique()
            ->values()
            ->toJson(JSON_NUMERIC_CHECK);

        $labels = json_decode($labels, true);
        $datasets = collect($repository->getContent($this->target))->values()->map(function ($dataset, $index) {
            return array_filter([
                'name'      => $dataset['name'] ?? $dataset['title'] ?? 'Series '.($index + 1),
                'values'    => array_map(fn ($value) => is_numeric($value) ? $value + 0 : $value, $dataset['values']),
                'color'     => $dataset['color'] ?? null,
                'chartType' => $this->type === self::TYPE_AXIS_MIXED ? ($dataset['chartType'] ?? 'line') : null,
            ], fn ($value) => $value !== null);
        })->all();

        if (in_array($this->type, [self::TYPE_PIE, self::TYPE_PERCENTAGE], true)) {
            // Composition charts represent category totals across all series.
            $totals = collect($labels)->map(fn ($label, $index) => [
                'label' => $label,
                'value' => array_sum(array_column(array_column($datasets, 'values'), $index)),
            ])->filter(fn ($slice) => $slice['value'] >= 0)->values();

            $labels = $totals->pluck('label')->all();
            $datasets = [['values' => $totals->pluck('value')->all()]];
        }

        return view($this->template, [
            'title'       => __($this->title),
            'description' => __($this->description),
            'export'      => $this->export,
            'chart'       => [
                'type'        => $this->type === self::TYPE_AXIS_MIXED ? 'mixed' : $this->type,
                'labels'      => $labels,
                'datasets'    => $datasets,
                'height'      => $this->height,
                'colors'      => $this->colors,
                'maxSlices'   => $this->maxSlices,
                'valueLabels' => (bool) $this->valuesOverPoints,
                'stacked'     => (bool) ($this->barOptions['stacked'] ?? false),
                'line'        => [
                    'area'    => (bool) ($this->lineOptions['regionFill'] ?? false),
                    'dots'    => ! ($this->lineOptions['hideDots'] ?? false),
                    'line'    => ! ($this->lineOptions['hideLine'] ?? false),
                    'dotSize' => $this->lineOptions['dotSize'] ?? 4,
                    'smooth'  => (bool) ($this->lineOptions['spline'] ?? false),
                ],
                'markers' => collect($this->markers())->map(fn ($marker) => [
                    'label'         => $marker['label'] ?? '',
                    'value'         => $marker['value'],
                    'lineStyle'     => 'dashed',
                    'labelPosition' => ($marker['options']['labelPos'] ?? 'right') === 'left' ? 'start' : 'end',
                ])->all(),
            ],
        ]);
    }
}
