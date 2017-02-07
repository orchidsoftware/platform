<?php

namespace Orchid\Foundation\Filters;

use Orchid\Foundation\Kernel\Storage;

class ContentFilterStorage extends Storage
{
    /**
     * @var string
     */
    protected $configField = 'content.contentFilters';
}
