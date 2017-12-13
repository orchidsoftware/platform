<?php

namespace Orchid\Platform\Core\Models;

use Orchid\Platform\Core\Traits\Attachment;
use Orchid\Platform\Core\Traits\MultiLanguage;
use Orchid\Platform\Core\Traits\FilterTrait;

class Category extends Taxonomy
{
    use Attachment, MultiLanguage, FilterTrait;

    /**
     * Used to set the post's type.
     */
    protected $taxonomy = 'category';
}
