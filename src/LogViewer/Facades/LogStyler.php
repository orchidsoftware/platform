<?php

namespace Orchid\LogViewer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class     LogStyler.
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class LogStyler extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'arcanedev.log-viewer.styler';
    }
}
