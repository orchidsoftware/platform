<?php

namespace Orchid\Platform\Layouts;

abstract class Rows
{
    /**
     * @var string
     */
    public $template = "dashboard::container.layouts.rows";

    /**
     * @return array
     */
    public function fields() : array
    {
        return [];
    }
}
