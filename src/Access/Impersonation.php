<?php

declare(strict_types=1);

namespace Orchid\Access;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class Impersonation
{
    public const SESSION_NAME = 'orchid:impersonation_original_user';

    /**
     * Changes the current authorization to the required.
     */
    public static function loginAs(User $user)
    {
        if (! session()->has(self::SESSION_NAME)) {
            session()->put(self::SESSION_NAME, self::getAuth()->id());
        }

        self::getAuth()->loginUsingId($user->getKey());
    }

    /**
     * Returns the previous session, before the user changes.
     */
    public static function logout()
    {
        $id = session()->pull(self::SESSION_NAME);

        self::getAuth()->loginUsingId($id);
    }

    public static function isSwitch(): bool
    {
        if (! session()->isStarted()) {
            session()->start();
        }

        return session()->has(self::SESSION_NAME);
    }

    /**
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    protected static function getAuth()
    {
        return Auth::guard(config('platform.guard'));
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public static function impersonator(): Authenticatable|null
    {
        if (self::isSwitch()) {
            $id = session()->get(self::SESSION_NAME);

            return self::getAuth()->getProvider()->retrieveById($id);
        }

        return null;
    }
}
