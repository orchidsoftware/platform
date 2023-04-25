<?php

declare(strict_types=1);

namespace Orchid\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Alert\Toast as ToastClass;

/**
 * Facade to create Toast notifications.
 *
 * @method static ToastClass info(string $message)                              Fires an info Toast notification with a message.
 * @method static ToastClass success(string $message)                           Fires a success Toast notification with a message.
 * @method static ToastClass error(string $message)                             Fires an error Toast notification with a message.
 * @method static ToastClass warning(string $message)                           Fires a warning Toast notification with a message.
 * @method static ToastClass view(string $template, string $level, array $data) Fires a Toast notification using a custom Blade view.
 * @method static ToastClass check()                                            Determines whether any Toast notifications were fired.
 * @method static ToastClass autoHide(bool $autoHide = true)                    Sets a value indicating whether Toast notifications should automatically hide.
 * @method static ToastClass delay(int $delay = 5000)                           Sets the number of seconds that a Toast notification should stay visible.
 * @method static ToastClass withoutEscaping()                                  Sets a value indicating whether to escape HTML in Toast notifications.
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
