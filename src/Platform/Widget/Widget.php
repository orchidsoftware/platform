<?php

declare(strict_types=1);

namespace Orchid\Platform\Widget;

class Widget implements WidgetContractInterface
{
    /**
     * @param      $key
     * @param null $arg
     *
     * @return mixed
     */
    public function get(string $key, $arg = null)
    {
        $class = config('widget.widgets.'.$key);
        $widget = new $class();

        return $widget->handler($arg);
    }

    /**
     * Soother.
     */
    public function handler()
    {
    }
}
