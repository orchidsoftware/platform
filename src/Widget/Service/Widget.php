<?php

namespace Orchid\Widget\Service;

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

        return $widget->run($arg);
    }

    /**
     * Soother.
     */
    public function run()
    {
    }
}
