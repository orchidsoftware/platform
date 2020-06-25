<?php

declare(strict_types=1);

namespace Orchid\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Screen\LayoutFactory;
use Orchid\Screen\Layout as AbstractLayout;

/**
 * Class Layout.
 *
 * @method static AbstractLayout view(string $view, array $data = [])
 * @method static AbstractLayout component(string $component)
 * @method static AbstractLayout rows(array $fields)
 * @method static AbstractLayout table(string $target, array $columns)
 * @method static AbstractLayout columns(array $layouts)
 * @method static AbstractLayout tabs(array $layouts)
 * @method static AbstractLayout modal(string $key, array $layouts)
 * @method static AbstractLayout blank(array $layouts)
 * @method static AbstractLayout collapse(array $fields)
 * @method static AbstractLayout wrapper(string $template, array $layouts)
 * @method static AbstractLayout accordion(array $layouts)
 * @method static AbstractLayout rubbers(array $layouts)
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
