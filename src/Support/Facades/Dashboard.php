<?php

declare(strict_types=1);

namespace Orchid\Support\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Orchid\Platform\Dashboard as DashboardKernel;

/**
 * Class Dashboard.
 *
 * @method Collection getSearch()
 * @method static Collection getPermission()
 * @method static string version()
 * @method static string prefix(string $path = '')
 * @method static configure(array $options)
 * @method static option(string $key, $default = null)
 * @method static modelClass(string $key, string $default = null)
 * @method static model(string $key, string $default = null)
 * @method static useModel(string $key, string $custom)
 * @method static bool checkUpdate()
 */
class Dashboard extends Facade
{
    /**
     * Initiate a mock expectation on the facade.
     *
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return DashboardKernel::class;
    }
}
