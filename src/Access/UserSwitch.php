<?php

declare(strict_types=1);

namespace Orchid\Access;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class UserSwitch
{
    public const SESSION_NAME = 'original_user';

    /**
     * Changes the current authorization to the required.
     *
     * @param User $user
     */
    public static function loginAs(User $user)
    {
        if (!session()->has(self::SESSION_NAME)) {
            session()->put(self::SESSION_NAME, Auth::id());
        }

        Auth::login($user);
    }

    /**
     * Returns the previous session, before the user changes.
     */
    public static function logout()
    {
        $id = session()->pull(self::SESSION_NAME);
        Auth::loginUsingId($id);
    }

    /**
     * @return bool
     */
    public static function isSwitch(): bool
    {
        return session()->has(self::SESSION_NAME);
    }
}
