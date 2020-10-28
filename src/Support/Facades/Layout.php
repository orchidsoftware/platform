<?php

declare(strict_types=1);

namespace Orchid\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Screen\Layout as BaseLayout;
use Orchid\Screen\LayoutFactory;
use Orchid\Screen\Layouts\Accordion;
use Orchid\Screen\Layouts\Blank;
use Orchid\Screen\Layouts\Collapse;
use Orchid\Screen\Layouts\Columns;
use Orchid\Screen\Layouts\Component;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Layouts\Selection;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Layouts\Tabs;
use Orchid\Screen\Layouts\View;
use Orchid\Screen\Layouts\Wrapper;

/**
 * Class Layout.
 *
 * @method static View view(string $view, array $data = [])
 * @method static Component component(string $component)
 * @method static Rows rows(array $fields)
 * @method static Table table(string $target, array $columns)
 * @method static Columns columns(BaseLayout[] $layouts)
 * @method static Tabs tabs(BaseLayout[] $layouts)
 * @method static Modal modal(string $key, string[]|string $layouts)
 * @method static Blank blank(BaseLayout[] $layouts)
 * @method static Collapse collapse(array $fields)
 * @method static Wrapper wrapper(string $template, array $layouts)
 * @method static Accordion accordion(BaseLayout[] $layouts)
 * @method static Selection selection(array $filters)
 */
class Layout extends Facade
{
    /**
     * Initiate a mock expectation on the facade.
     *
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return LayoutFactory::class;
    }
}
