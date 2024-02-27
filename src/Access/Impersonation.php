<?php

declare(strict_types=1);

namespace Orchid\Access;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class Impersonation
{
    // The name of the session variable where the original authenticated user ID is stored
    public const SESSION_NAME = 'orchid:impersonation_original_user';

    /**
     * Changes the current authenticated user to the given user.
     *
     * @param Authenticatable $user The user to switch to
     *
     * @return void
     */
    public static function loginAs(Authenticatable $user): void
    {
        // Store the original authenticated user ID in the session if it's not already there
        if (! session()->has(self::SESSION_NAME)) {
            session()->put(self::SESSION_NAME, self::getAuth()->id());
        }

        // Log in the given user
        self::getAuth()->loginUsingId($user->getAuthIdentifier());
    }

    /**
     * Restores the previous session, before the user was changed.
     */
    public static function logout(): void
    {
        // Retrieve the original authenticated user ID from the session
        $id = session()->pull(self::SESSION_NAME);

        // Log in the original authenticated user
        self::getAuth()->loginUsingId($id);
    }

    /**
     * Checks if there has been a user switch.
     *
     * @return bool
     */
    public static function isSwitch(): bool
    {
        // Start the session if it hasn't been started yet
        if (! session()->isStarted()) {
            session()->start();
        }

        // Check if the original authenticated user ID has been stored in the session
        return session()->has(self::SESSION_NAME);
    }

    /**
     * Check if the current user is impersonated.
     *
     * @alias static bool isSwitch()
     *
     * @return bool
     */
    public static function isImpersonating(): bool
    {
        return self::isSwitch();
    }

    /**
     * Returns the authentication guard.
     *
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    protected static function getAuth()
    {
        // Get the authentication guard specified in the config file
        return Auth::guard(config('platform.guard'));
    }

    /**
     * Returns the impersonator (the original authenticated user), if there has been a user switch.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null The impersonator or null if there has been no user switch
     */
    public static function impersonator(): ?Authenticatable
    {
        // Check if there has been a user switch
        if (! self::isSwitch()) {
            return null;
        }

        // Retrieve the original authenticated user from the provider using the stored ID
        $id = session()->get(self::SESSION_NAME);

        return self::getAuth()->getProvider()->retrieveById($id);
    }
}
