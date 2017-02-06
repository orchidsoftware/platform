<?php

namespace Orchid\Foundation\Filters;

use Orchid\Foundation\Kernel\Storage;

class FilterStorage extends Storage
{
    /**
     * @var string
     */
    protected $configField = 'content.fieldFilters';
}
