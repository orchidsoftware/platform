<?php

namespace Orchid\Widget\Service;

abstract class Widget implements WidgetContractInterface
{
    /**
     * @param $key
     *
     * @return mixed
     */
    public function get($key)
    {
        $class = config('widget.widgets.'.$key);
        $widget = new $class();

        return $widget->run();
    }

    /**
     * Soother.
     */
    abstract public function run();
}
