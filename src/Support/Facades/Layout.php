<?php

declare(strict_types=1);

namespace Orchid\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Screen\LayoutFactory;
use Orchid\Screen\Layouts\Accordion;
use Orchid\Screen\Layouts\Blank;
use Orchid\Screen\Layouts\Collapse;
use Orchid\Screen\Layouts\Columns;
use Orchid\Screen\Layouts\Component;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Layouts\Rows;
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
 * @method static Columns columns(array $layouts)
 * @method static Tabs tabs(array $layouts)
 * @method static Modal modal(string $key, array $layouts)
 * @method static Blank blank(array $layouts)
 * @method static Collapse collapse(array $fields)
 * @method static Wrapper wrapper(string $template, array $layouts)
 * @method static Accordion accordion(array $layouts)
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
