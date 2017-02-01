<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 01.02.17
 * Time: 16:21
 */

namespace Orchid\Foundation\Filters;

use Orchid\Foundation\Kernel\Storage;

class ContentFilterStorage extends Storage {
    protected $configField = 'content.contentFilters';
}