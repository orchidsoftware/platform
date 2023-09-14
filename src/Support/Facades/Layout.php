<?php

declare(strict_types=1);

namespace Orchid\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Screen\Layout as BaseLayout;
use Orchid\Screen\LayoutFactory;
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
 * Class Layout.
 *
 * This class provides a static interface for creating layouts.
 * Are defined as classes within the Orchid\Screen\Layouts namespace.
 *
 * @method static View      view(string $view, array $data = [])                    Creates a new view layout with the given data.
 * @method static Component component(string $component)                            Creates a new component layout with the given component.
 * @method static Rows      rows(array $fields)                                     Creates a new rows layout with the given fields.
 * @method static Table     table(string $target, array $columns)                   Creates a new table layout with the given target and columns.
 * @method static Columns   columns(BaseLayout[]|string[] $layouts)                 Creates a new columns layout with the given layout data.
 * @method static Tabs      tabs(BaseLayout[] $layouts)                             Creates a new tabs layout with the given layout data.
 * @method static Modal     modal(string $key, string[]|string|BaseLayout $layouts) Creates a new modal layout with the given key and layout data.
 * @method static Blank     blank(BaseLayout[] $layouts)                            Creates a new blank layout with the given layout data.
 * @method static Wrapper   wrapper(string $template, array $layouts)               Creates a new wrapper layout with the given template and layout data.
 * @method static Accordion accordion(BaseLayout[] $layouts)                        Creates a new accordion layout with the given layout data.
 * @method static Selection selection(array $filters)                               Creates a new selection layout with the given filters.
 * @method static Block     block(BaseLayout|string|string[] $layouts)              Creates a new block layout with the given layout data.
 * @method static Legend    legend(string $target, array $columns)                  Creates a new legend layout with the given target and columns.
 * @method static Browsing  browsing(string $src)                                   Creates a new browsing layout with the given src.
 * @method static Metric    metrics(array $labels)                                  Creates a new metrics layout with the given labels.
 * @method static Split     split(array $layouts)                                   Creates a new split layout with the given layout data.
 * @method static Chart     chart(string $target, string $title = null)             Creates a new chart layout with the given title.
 * @method static Sortable  sortable(string $target, array $columns)                Creates a new sortable layout with the given target and columns.
 */
class Layout extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return LayoutFactory::class;
    }
}
