<?php

declare(strict_types=1);

namespace Orchid\Support\Facades;

use Orchid\Alert\Alert as AlertClass;
use Illuminate\Support\Facades\Facade;

/**
 * Class Alert.
 *
 * @method static Alert info(string $name)
 * @method static Alert success(string $name)
 * @method static Alert danger(string $name)
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
