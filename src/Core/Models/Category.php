<?php

namespace Orchid\Platform\Core\Models;

use Orchid\Platform\Core\Traits\Attachment;

class Category extends Taxonomy
{
    use Attachment;

    /**
     * Used to set the post's type.
     */
    protected $taxonomy = 'category';
}
