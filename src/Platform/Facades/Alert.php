<?php

declare(strict_types=1);

namespace Orchid\Platform\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Platform\Alert\Alert as AlertClass;

/**
 * Class Alert.
 *
 * @method static Alert info(string $name)
 * @method static Alert success(string $name)
 * @method static Alert error(string $name)
 * @method static Alert warning(string $name)
 */
class Alert extends Facade
{
    /**
     * Initiate a mock expectation on the facade.
     *
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return AlertClass::class;
    }
}
