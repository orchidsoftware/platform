<?php

namespace Orchid\Platform\Layouts;

abstract class Tabs
{
    /**
     * @var string
     */
    public $template = "dashboard::container.layouts.tabs";

    /**
     * @return array
     */
    public function layout() : array
    {
        return [];
    }
}
