<?php

declare(strict_types=1);

namespace Orchid\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Screen\LayoutFactory;

/**
 * @mixin LayoutFactory
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
