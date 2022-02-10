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
use Orchid\Screen\Layouts\Columns;
use Orchid\Screen\Layouts\Component;
use Orchid\Screen\Layouts\Legend;
use Orchid\Screen\Layouts\Metric;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Layouts\Selection;
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
     * @param string          $view
     * @param Arrayable|array $data
     *
     * @return View
     */
    public static function view(string $view, $data = []): View
    {
        return new class($view, $data) extends View {
        };
    }

    /**
     * @param string $component
     *
     * @return Component
     */
    public static function component(string $component): Component
    {
        return new class($component) extends Component {
        };
    }

    /**
     * @param array $fields
     *
     * @return Rows
     */
    public static function rows(array $fields): Rows
    {
        return new class($fields) extends Rows {
            /**
             * @var Field[]
             */
            protected $fields;

            /**
             *  constructor.
             *
             * @param array $fields
             */
            public function __construct(array $fields = [])
            {
                $this->fields = $fields;
            }

            /**
             * @return array
             */
            public function fields(): array
            {
                return $this->fields;
            }
        };
    }

    /**
     * @param string $target
     * @param array  $columns
     *
     * @return Table
     */
    public static function table(string $target, array $columns): Table
    {
        return new class($target, $columns) extends Table {

            /**
             * @var array
             */
            protected $columns;

            /**
             * @param string $target
             * @param array  $columns
             */
            public function __construct(string $target, array $columns)
            {
                $this->target = $target;
                $this->columns = $columns;
            }

            /**
             * @return array
             */
            public function columns(): array
            {
                return $this->columns;
            }
        };
    }

    /**
     * @param array $layouts
     *
     * @return Columns
     */
    public static function columns(array $layouts): Columns
    {
        return new class($layouts) extends Columns {
        };
    }

    /**
     * @param array $layouts
     *
     * @return Tabs
     */
    public static function tabs(array $layouts): Tabs
    {
        return new class($layouts) extends Tabs {
        };
    }

    /**
     * @param string          $key
     * @param string|string[] $layouts
     *
     * @return Modal
     */
    public static function modal(string $key, $layouts): Modal
    {
        $layouts = Arr::wrap($layouts);

        return new class($key, $layouts) extends Modal {
        };
    }

    /**
     * @param array $layouts
     *
     * @return Blank
     */
    public static function blank(array $layouts): Blank
    {
        return new class($layouts) extends Blank {
        };
    }

    /**
     * @param string $template
     * @param array  $layouts
     *
     * @return Wrapper
     */
    public static function wrapper(string $template, array $layouts): Wrapper
    {
        return new class($template, $layouts) extends Wrapper {
        };
    }

    /**
     * @param array $layouts
     *
     * @return Accordion
     */
    public static function accordion(array $layouts): Accordion
    {
        return new class($layouts) extends Accordion {
        };
    }

    /**
     * @param string[] $filters
     *
     * @return Selection
     */
    public static function selection(array $filters): Selection
    {
        return new class($filters) extends Selection {
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
     *
     * @return Block
     */
    public static function block($layouts): Block
    {
        return new class(Arr::wrap($layouts)) extends Block {
        };
    }

    /**
     * @param string $target
     * @param array  $columns
     *
     * @return Legend
     */
    public static function legend(string $target, array $columns): Legend
    {
        return new class($target, $columns) extends Legend {

            /**
             * @var array
             */
            protected $columns;

            /**
             * @param string $target
             * @param array  $columns
             */
            public function __construct(string $target, array $columns)
            {
                $this->target = $target;
                $this->columns = $columns;
            }

            /**
             * @return array
             */
            public function columns(): array
            {
                return $this->columns;
            }
        };
    }

    /**
     * @param string $src
     *
     * @return Browsing
     */
    public static function browsing(string $src): Browsing
    {
        return new Browsing($src);
    }

    /**
     * @param array $labels
     *
     * @return Metric
     */
    public static function metrics(array $labels): Metric
    {
        return new Metric($labels);
    }
}
