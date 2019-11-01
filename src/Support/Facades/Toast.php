<?php

declare(strict_types=1);

namespace Orchid\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Alert\Toast as ToastClass;

/**
 * Class Toast.
 *
 * @method static ToastClass info(string $message)
 * @method static ToastClass success(string $message)
 * @method static ToastClass error(string $message)
 * @method static ToastClass warning(string $message)
 * @method static ToastClass view(string $template, string $level, array $data)
 * @method static ToastClass check()
 *
 * @mixin ToastClass
 */
class Toast extends Facade
{
    /**
     * Initiate a mock expectation on the facade.
     *
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return ToastClass::class;
    }
}
