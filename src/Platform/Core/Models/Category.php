<?php

namespace Orchid\Platform\Core\Models;

use Orchid\Platform\Core\Traits\Attachment;
use Orchid\Platform\Core\Traits\MultiLanguage;

class Category extends Taxonomy
{
    use Attachment, MultiLanguage;

    /**
     * Used to set the post's type.
     */
    protected $taxonomy = 'category';
}
