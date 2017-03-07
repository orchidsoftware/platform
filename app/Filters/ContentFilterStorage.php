<?php

namespace Orchid\Filters;

use Orchid\Kernel\Storage;

class ContentFilterStorage extends Storage
{
    /**
     * @var string
     */
    protected $configField = 'content.contentFilters';
}
