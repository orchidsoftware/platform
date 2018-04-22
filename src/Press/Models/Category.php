<?php

declare(strict_types=1);

namespace Orchid\Press\Models;

use Orchid\Platform\Traits\Attachment;
use Orchid\Platform\Traits\FilterTrait;
use Orchid\Platform\Traits\MultiLanguage;

class Category extends Taxonomy
{
    use Attachment, MultiLanguage, FilterTrait;

    /**
     * Used to set the post's type.
     */
    protected $taxonomy = 'category';
}
