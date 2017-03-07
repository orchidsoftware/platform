<?php

namespace Orchid\Filters;

use Orchid\Kernel\Storage;

class FilterStorage extends Storage
{
    /**
     * @var string
     */
    protected $configField = 'content.fieldFilters';
}
