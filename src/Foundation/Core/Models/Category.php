<?php

namespace Orchid\Foundation\Core\Models;

class Category extends TermTaxonomy
{
    /**
     * Used to set the post's type.
     */
    protected $taxonomy = 'category';
}
