<?php namespace Orchid\LogViewer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class     LogViewer
 *
 * @package  Orchid\LogViewer\Facades
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class LogViewer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'arcanedev.log-viewer';
    }
}
