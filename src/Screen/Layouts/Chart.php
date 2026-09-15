<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use InvalidArgumentException;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

class Chart extends Layout
{
    public const TYPE_BAR = 'bar';
    public const TYPE_LINE = 'line';
    public const TYPE_PIE = 'pie';
    public const TYPE_PERCENTAGE = 'percentage';
    public const TYPE_MIXED = 'mixed';

    protected $template = 'orchid::layouts.chart';

    protected string $target = '';

    protected ?string $title = null;

    protected ?string $description = null;

    protected string $type = self::TYPE_LINE;

    protected bool $export = false;

    /** Options use the same names as Orchid Charts. */
    protected array $options = [
        'height' => 250,
        'colors' => [
            '#2ec7c9', '#b6a2de', '#5ab1ef', '#ffb980', '#d87a80',
            '#8d98b3', '#e5cf0d', '#97b552', '#95706d', '#dc69aa',
            '#07a2a4', '#9a7fd1', '#588dd5', '#f5994e', '#c05050',
            '#59678c', '#c9ab00', '#7eb00a', '#6f5553', '#c14089',
        ],
    ];

    protected array $markers = [];

    public static function make(string $target, ?string $title = null): static
    {
        return (new static)->target($target)->title($title);
    }

    public function target(string $target): static
    {
        $this->target = $target;

        return $this;
    }

    public function title(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function description(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function type(string $type): static
    {
        if (! in_array($type, [self::TYPE_LINE, self::TYPE_BAR, self::TYPE_MIXED, self::TYPE_PIE, self::TYPE_PERCENTAGE], true)) {
            throw new InvalidArgumentException("Unsupported chart type: {$type}");
        }

        $this->type = $type;

        return $this;
    }

    /** Merge presentation options without replacing earlier settings. */
    public function options(array $options): static
    {
        $this->options = array_replace($this->options, $options);

        return $this;
    }

    public function height(int $height): static
    {
        return $this->options(['height' => $height]);
    }

    public function colors(array $colors): static
    {
        return $this->options(['colors' => array_values($colors)]);
    }

    public function gradient(bool|array $gradient = true): static
    {
        return $this->options(['gradient' => $gradient]);
    }

    public function smooth(bool $smooth = true): static
    {
        return $this->options(['smooth' => $smooth]);
    }

    public function dots(bool $dots = true): static
    {
        return $this->options(['dots' => $dots]);
    }

    public function stacked(bool $stacked = true): static
    {
        return $this->options(['stacked' => $stacked]);
    }

    public function legend(bool $legend = true): static
    {
        return $this->options(['legend' => $legend]);
    }

    public function maxSlices(int $maxSlices): static
    {
        return $this->options(['maxSlices' => $maxSlices]);
    }

    public function marker(string $label, int|float $value, array $options = []): static
    {
        $this->markers[] = ['label' => $label, 'value' => $value] + $options;

        return $this;
    }

    public function export(bool $export = true): static
    {
        $this->export = $export;

        return $this;
    }

    /** @return Factory|View|null */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return;
        }

        $data = $repository->getContent($this->target);

        if (! is_array($data) || ! is_array($data['labels'] ?? null) || ! is_array($data['datasets'] ?? null)) {
            throw new InvalidArgumentException("Chart [{$this->target}] expects labels and datasets.");
        }

        $common = ['height', 'width', 'colors', 'legend', 'tooltip'];
        $axes = ['axes', 'grid', 'valueLabels', 'frameless'];
        $supported = match ($this->type) {
            self::TYPE_LINE       => [...$axes, 'smooth', 'dots', 'dotSize', 'line', 'area', 'gradient', 'strokeWidth'],
            self::TYPE_BAR        => [...$axes, 'stacked', 'horizontal', 'radius'],
            self::TYPE_MIXED      => [...$axes, 'gradient'],
            self::TYPE_PIE        => ['maxSlices', 'startAngle', 'padAngle'],
            self::TYPE_PERCENTAGE => ['maxSlices'],
        };

        foreach (array_keys($this->options) as $option) {
            if (! in_array($option, [...$common, ...$supported], true)) {
                throw new InvalidArgumentException("Unsupported {$this->type} chart option: {$option}");
            }
        }

        if (in_array($this->type, [self::TYPE_PIE, self::TYPE_PERCENTAGE], true) && count($data['datasets']) !== 1) {
            throw new InvalidArgumentException("A {$this->type} chart requires exactly one dataset.");
        }

        // Reindex PHP collections so the transport always contains JSON arrays.
        $data['labels'] = array_values($data['labels']);
        $data['datasets'] = array_values(array_map(function (array $dataset) use ($data) {
            if (! is_array($dataset['values'] ?? null)) {
                throw new InvalidArgumentException("Chart [{$this->target}] expects an array of dataset values.");
            }

            $dataset['values'] = array_values(array_map(
                fn ($value) => is_numeric($value) ? $value + 0 : $value,
                $dataset['values'],
            ));

            if (count($dataset['values']) !== count($data['labels'])) {
                throw new InvalidArgumentException("Chart [{$this->target}] requires a value for every label in each dataset.");
            }

            return $dataset;
        }, $data['datasets']));

        if ($this->markers !== []) {
            $data['markers'] = array_merge($data['markers'] ?? [], $this->markers);
        }

        return view($this->template, [
            'title'       => __($this->title ?? ''),
            'description' => __($this->description ?? ''),
            'export'      => $this->export,
            'height'      => (int) $this->options['height'],
            'chart'       => [
                'type'    => $this->type,
                'options' => $this->options,
                'data'    => $data,
            ],
        ]);
    }
}
