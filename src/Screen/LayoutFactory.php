<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;
use Orchid\Screen\Layouts\Accordion;
use Orchid\Screen\Layouts\Blank;
use Orchid\Screen\Layouts\Block;
use Orchid\Screen\Layouts\Browsing;
use Orchid\Screen\Layouts\Chart;
use Orchid\Screen\Layouts\Columns;
use Orchid\Screen\Layouts\Component;
use Orchid\Screen\Layouts\Legend;
use Orchid\Screen\Layouts\Metric;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Layouts\Selection;
use Orchid\Screen\Layouts\Sortable;
use Orchid\Screen\Layouts\Split;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Layouts\Tabs;
use Orchid\Screen\Layouts\View;
use Orchid\Screen\Layouts\Wrapper;

/**
 * Class LayoutFactory.
 */
class LayoutFactory
{
    use Macroable;

    /**
     * @param Arrayable|array $data
     */
    public static function view(string $view, $data = []): View
    {
        return new class($view, $data) extends View {};
    }

    public static function component(string $component): Component
    {
        return new class($component) extends Component {};
    }

    public static function rows(array $fields): Rows
    {
        return new class($fields) extends Rows
        {
            /**
             * @var Field[]
             */
            protected $fields;

            /**
             *  constructor.
             */
            public function __construct(array $fields = [])
            {
                $this->fields = $fields;
            }

            public function fields(): array
            {
                return $this->fields;
            }
        };
    }

    public static function table(string $target, array $columns): Table
    {
        return new class($target, $columns) extends Table
        {
            /**
             * @var array
             */
            protected $columns;

            public function __construct(string $target, array $columns)
            {
                $this->target = $target;
                $this->columns = $columns;
            }

            public function columns(): array
            {
                return $this->columns;
            }
        };
    }

    public static function columns(array $layouts): Columns
    {
        return new class($layouts) extends Columns {};
    }

    public static function split(array $layouts): Split
    {
        return new class($layouts) extends Split {};
    }

    public static function tabs(array $layouts): Tabs
    {
        return new class($layouts) extends Tabs {};
    }

    /**
     * @param string|string[] $layouts
     */
    public static function modal(string $key, $layouts): Modal
    {
        $layouts = Arr::wrap($layouts);

        return new class($key, $layouts) extends Modal {};
    }

    public static function blank(array $layouts): Blank
    {
        return new class($layouts) extends Blank {};
    }

    public static function wrapper(string $template, array $layouts): Wrapper
    {
        return new class($template, $layouts) extends Wrapper {};
    }

    public static function accordion(array $layouts): Accordion
    {
        return new class($layouts) extends Accordion {};
    }

    /**
     * @param string[] $filters
     */
    public static function selection(array $filters): Selection
    {
        return new class($filters) extends Selection
        {
            /**
             * @var string[]
             */
            protected $filters;

            /**
             * Constructor.
             *
             * @param string[] $filters
             */
            public function __construct(array $filters = [])
            {
                $this->filters = $filters;
            }

            /**
             * @return string[]
             */
            public function filters(): array
            {
                return $this->filters;
            }
        };
    }

    /**
     * @param Layout|string|string[] $layouts
     */
    public static function block($layouts): Block
    {
        return new class(Arr::wrap($layouts)) extends Block {};
    }

    public static function legend(string $target, array $columns): Legend
    {
        return new class($target, $columns) extends Legend
        {
            /**
             * @var array
             */
            protected $columns;

            public function __construct(string $target, array $columns)
            {
                $this->target = $target;
                $this->columns = $columns;
            }

            public function columns(): array
            {
                return $this->columns;
            }
        };
    }

    public static function browsing(string $src): Browsing
    {
        return new Browsing($src);
    }

    public static function metrics(array $labels): Metric
    {
        return new Metric($labels);
    }

    /**
     * @param string      $target
     * @param string|null $title
     *
     * @return \Orchid\Screen\Layouts\Chart
     */
    public static function chart(string $target, ?string $title = null): Chart
    {
        $chart = new class extends Chart {};

        return $chart
            ->target($target)
            ->title($title);
    }

    /**
     * @param string $target
     * @param array  $columns
     *
     * @return \Orchid\Screen\Layouts\Sortable
     */
    public static function sortable(string $target, array $columns): Sortable
    {
        return new class($target, $columns) extends Sortable
        {
            /**
             * @var array
             */
            protected $columns;

            public function __construct(string $target, array $columns)
            {
                $this->target = $target;
                $this->columns = $columns;
            }

            public function columns(): iterable
            {
                return $this->columns;
            }
        };
    }
}
