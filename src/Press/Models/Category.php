<?php

declare(strict_types=1);

namespace Orchid\Press\Models;

use Orchid\Platform\Traits\AttachTrait;
use Orchid\Platform\Traits\FilterTrait;
use Orchid\Platform\Traits\MultiLanguageTrait;

class Category extends Taxonomy
{
    use AttachTrait, MultiLanguageTrait, FilterTrait;

    /**
     * Used to set the post's type.
     */
    protected $taxonomy = 'category';
}
