<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;
use Orchid\Filters\Filter;
use Orchid\Screen\Contracts\Fieldable;
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
     * @param view-string                                   $view
     * @param Arrayable<string, mixed>|array<string, mixed> $data
     */
    public static function view(string $view, $data = []): View
    {
        return new class($view, $data) extends View {};
    }

    public static function component(string $component): Component
    {
        return new class($component) extends Component {};
    }

    /**
     * @param array<Fieldable> $fields
     */
    public static function rows(array $fields): Rows
    {
        return new class($fields) extends Rows
        {
            /**
             * @var Fieldable[]
             */
            protected $fields;

            /**
             * @param array<Fieldable> $fields
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

    /**
     * @param array<TD> $columns
     */
    public static function table(string $target, array $columns): Table
    {
        return new class($target, $columns) extends Table
        {
            /**
             * @var TD[]
             */
            protected $columns;

            /**
             * @param array<TD> $columns
             */
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

    /**
     * @param array<Layout|string|array<Layout|string>> $layouts
     */
    public static function columns(array $layouts): Columns
    {
        return new class($layouts) extends Columns {};
    }

    /**
     * @param array<Layout|string|array<Layout|string>> $layouts
     */
    public static function split(array $layouts): Split
    {
        return new class($layouts) extends Split {};
    }

    /**
     * @param array<Layout|string|array<Layout|string>> $layouts
     */
    public static function tabs(array $layouts): Tabs
    {
        return new class($layouts) extends Tabs {};
    }

    /**
     * @param Layout|string|array<Layout|string> $layouts
     */
    public static function modal(string $key, $layouts): Modal
    {
        $layouts = Arr::wrap($layouts);

        return new class($key, $layouts) extends Modal {};
    }

    /**
     * @param array<Layout|string|iterable<Layout|string>> $layouts
     */
    public static function blank(array $layouts): Blank
    {
        return new class($layouts) extends Blank {};
    }

    /**
     * @param view-string                               $template
     * @param array<Layout|string|array<Layout|string>> $layouts
     */
    public static function wrapper(string $template, array $layouts): Wrapper
    {
        return new class($template, $layouts) extends Wrapper {};
    }

    /**
     * @param array<Layout|string|array<Layout|string>> $layouts
     */
    public static function accordion(array $layouts): Accordion
    {
        return new class($layouts) extends Accordion {};
    }

    /**
     * @param array<Filter|class-string<Filter>> $filters
     */
    public static function selection(array $filters): Selection
    {
        return new class($filters) extends Selection
        {
            /**
             * @param array<Filter|class-string<Filter>> $filters
             */
            public function __construct(protected array $filters = []) {}

            public function filters(): array
            {
                return $this->filters;
            }
        };
    }

    /**
     * @param Layout|string|array<Layout|string> $layouts
     */
    public static function block($layouts): Block
    {
        return new class(Arr::wrap($layouts)) extends Block {};
    }

    /**
     * @param array<Sight> $columns
     */
    public static function legend(string $target, array $columns): Legend
    {
        return new class($target, $columns) extends Legend
        {
            /**
             * @var Sight[]
             */
            protected $columns;

            /**
             * @param array<Sight> $columns
             */
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

    /**
     * @param array<string> $labels
     */
    public static function metrics(array $labels): Metric
    {
        return new Metric($labels);
    }

    public static function chart(string $target, ?string $title = null): Chart
    {
        return Chart::make($target, $title);
    }

    /**
     * @param array<Sight> $columns
     */
    public static function sortable(string $target, array $columns): Sortable
    {
        return new class($target, $columns) extends Sortable
        {
            /**
             * @var Sight[]
             */
            protected $columns;

            /**
             * @param array<Sight> $columns
             */
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
