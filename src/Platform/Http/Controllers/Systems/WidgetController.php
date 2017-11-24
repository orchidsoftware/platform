<?php

namespace Orchid\Platform\Http\Controllers\Systems;

use Orchid\Platform\Widget\WidgetContractInterface;

class WidgetController
{

    /**
     * @param       $widget
     * @param array ...$arg
     *
     * @return mixed
     */
    public function index(WidgetContractInterface $widget, ...$arg)
    {
       return $widget->handler($arg);
    }

}
