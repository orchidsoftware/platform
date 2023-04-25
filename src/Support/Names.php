<?php

declare(strict_types=1);

namespace Orchid\Support;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * Names class
 *
 * This class provides a method for generating the class name based on the current route name
 * Adding a prefix and a separator to the generated class name
 * Replaces '.' with the separator and returns the string in slug form
 */
class Names
{
    /**
     * Get the current page name class
     *
     * @param string $prefix
     * @param string $separator
     *
     * @return string
     */
    public static function getPageNameClass(string $prefix = 'page', string $separator = '-'): string
    {
        return Route::currentRouteName()
            ? (string) Str::of($prefix.$separator.Route::currentRouteName())->replace('.', $separator)->slug()
            : $prefix;
    }
}
