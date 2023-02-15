<?php

declare(strict_types=1);

namespace Orchid\Support;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Names
{
    public static function getPageNameClass(string $prefix = 'page', string $separator = '-'): string
    {
        return Route::currentRouteName()
            ? (string) Str::of($prefix.$separator.Route::currentRouteName())->replace('.', $separator)->slug()
            : $prefix;
    }
}
