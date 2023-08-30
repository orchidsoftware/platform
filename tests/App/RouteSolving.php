<?php

namespace Orchid\Tests\App;

use Illuminate\Contracts\Routing\UrlRoutable;
use Stringable;

class RouteSolving implements Stringable, UrlRoutable
{
    public function resolveRouteBinding($value, $field = null)
    {
        return $this;
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

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Hello Word';
    }
}
