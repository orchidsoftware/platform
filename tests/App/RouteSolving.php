<?php

namespace Orchid\Tests\App;

use Illuminate\Contracts\Routing\UrlRoutable;

class RouteSolving implements UrlRoutable
{
    public function resolveRouteBinding($value, $field = null)
    {
        return 'Hello Word';
    }

    public function getRouteKey()
    {
        // TODO: Implement getRouteKey() method.
    }

    public function getRouteKeyName()
    {
        // TODO: Implement getRouteKeyName() method.
    }

    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }
}
