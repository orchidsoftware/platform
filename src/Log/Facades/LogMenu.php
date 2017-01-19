<?php

namespace Orchid\Log\Facades;

use Illuminate\Support\Facades\Facade;

class LogMenu extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'arcanedev.log-viewer.menu';
    }
}
