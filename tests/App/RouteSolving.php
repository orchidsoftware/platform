<?php

namespace Orchid\Tests\App;

use Illuminate\Contracts\Routing\UrlRoutable;
use Stringable;

class RouteSolving implements Stringable, UrlRoutable
{
    public function resolveRouteBinding($value, $field = null)
    {
        return $this; // @phpstan-ignore return.type (Laravel accepts custom UrlRoutable objects, not only Eloquent models.)
    }

    public function getRouteKey()
    {
        // TODO: Implement getRouteKey() method.
    }

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function resolveChildRouteBinding($childType, $value, $field)
    {
        return null;
    }

    public function __toString(): string
    {
        return 'Hello Word';
    }
}
