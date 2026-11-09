<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Contracts\Support\Arrayable;
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
use Orchid\Screen\Layouts\SideMenu;
use Orchid\Screen\Layouts\Sortable;
use Orchid\Screen\Layouts\Split;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Layouts\TabMenu;
use Orchid\Screen\Layouts\Tabs;
use Orchid\Screen\Layouts\View;
use Orchid\Screen\Layouts\Wrapper;

/**
 * Class LayoutFactory.
 */
class LayoutFactory
{
    use Macroable;

    public static function view(string $view, array|Arrayable $data = []): View
    {
        return View::make($view, $data);
    }

    public static function component(string $component): Component
    {
        return Component::make($component);
    }

    public static function rows(array $fields): Rows
    {
        return Rows::make($fields);
    }

    public static function table(array $columns): Table
    {
        return Table::make($columns);
    }

    public static function columns(array $layouts): Columns
    {
        return Columns::make($layouts);
    }

    public static function split(array $layouts): Split
    {
        return Split::make($layouts);
    }

    public static function tabs(array $layouts): Tabs
    {
        return Tabs::make($layouts);
    }

    public static function modal(string $key, array|string|Layout $layouts): Modal
    {
        return Modal::make($key, $layouts);
    }

    public static function blank(array $layouts): Blank
    {
        return Blank::make($layouts);
    }

    public static function wrapper(string $template, array $layouts): Wrapper
    {
        return Wrapper::make($template, $layouts);
    }

    public static function accordion(array $layouts): Accordion
    {
        return Accordion::make($layouts);
    }

    public static function selection(array $filters): Selection
    {
        return Selection::make($filters);
    }

    public static function block(array|string|Layout $layouts): Block
    {
        return Block::make($layouts);
    }

    public static function legend(array $columns): Legend
    {
        return Legend::make($columns);
    }

    public static function browsing(string $src): Browsing
    {
        return Browsing::make($src);
    }

    public static function metrics(array $labels): Metric
    {
        return Metric::make($labels);
    }

    public static function chart(string $target, ?string $title = null): Chart
    {
        return Chart::make($target, $title);
    }

    public static function sortable(array $columns): Sortable
    {
        return Sortable::make($columns);
    }

    public static function tabMenu(array $navigations): TabMenu
    {
        return TabMenu::make($navigations);
    }

    public static function sideMenu(array $navigations): SideMenu
    {
        return SideMenu::make($navigations);
    }
}
