<?php

declare(strict_types=1);

namespace Orchid\Widget;

/**
 * Class Widget.
 */
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
        $widget = $this->getWidgetFromConfig($key);

        return $widget->handler($arg);
    }

    /**
     * @param string $key
     *
     * @return \Orchid\Widget\Widget
     */
    private function getWidgetFromConfig(string $key): self
    {
        $class = config('widget.widgets.' . $key);

        return new $class;
    }

    /**
     * Soother.
     */
    public function handler()
    {
    }
}
