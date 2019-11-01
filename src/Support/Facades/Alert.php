<?php

declare(strict_types=1);

namespace Orchid\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Alert\Alert as AlertClass;

/**
 * Class Alert.
 *
 * @method static AlertClass info(string $message)
 * @method static AlertClass success(string $message)
 * @method static AlertClass error(string $message)
 * @method static AlertClass warning(string $message)
 * @method static AlertClass view(string $template, string $level, array $data)
 * @method static AlertClass check()
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
