<?php

namespace Orchid\Platform\Layouts;

abstract class Colums
{
    /**
     * @var string
     */
    public $template = "dashboard::container.layouts.colums";

    /**
     * @return array
     */
    public function layout() : array
    {
        return [];
    }
}
