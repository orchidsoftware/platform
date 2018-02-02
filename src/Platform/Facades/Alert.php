<?php

declare(strict_types=1);

namespace Orchid\Platform\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Platform\Alert\Alert as AlertClass;

/**
 * Class Alert.
 */
class Alert extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return AlertClass::class;
    }
}
