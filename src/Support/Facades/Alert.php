<?php

declare(strict_types=1);

namespace Orchid\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Alert\Alert as AlertClass;
use Orchid\Support\Color;

/**
 * Class Alert.
 *
 * @method static AlertClass info(string $message)
 * @method static AlertClass success(string $message)
 * @method static AlertClass error(string $message)
 * @method static AlertClass warning(string $message)
 * @method static AlertClass view(string $template, Color $level, array $data)
 * @method static AlertClass check()
 * @method static AlertClass message(string $message, string $level = null)
 * @method static AlertClass withoutEscaping()
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
