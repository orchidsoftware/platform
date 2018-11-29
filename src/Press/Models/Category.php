<?php

declare(strict_types=1);

namespace Orchid\Press\Models;

use Orchid\Platform\Traits\AttachTrait;
use Orchid\Platform\Traits\FilterTrait;
use Orchid\Platform\Traits\MultiLanguageTrait;

class Category extends Taxonomy
{
    use AttachTrait,
        MultiLanguageTrait,
        FilterTrait;

    /**
     * Used to set the post's type.
     */
    protected $taxonomy = 'category';

    /**
     *  Set taxonomy.
     *
     *
     * @return $this
     */
    public function setTaxonomy()
    {
        $this['taxonomy'] = $this->taxonomy;

        return $this;
    }

    /**
     * Select all other categories.
     *
     *
     * @return array
     */
    public function allOtherCategory()
    {
        $categoryes = ($this->exists) ? self::whereNotIn('id', [$this->id])->get() : self::get();
        foreach ($categoryes as $category) {
            $allOtherCategory[$category->id] = $category->term->GetContent('name');
        }

        return $allOtherCategory ?? [];
    }

    /**
     *  Create category term.
     *
     * @param array $term
     *
     * @return $this
     */
    public function newWithCreateTerm($term): self
    {
        $newTerm = Term::firstOrCreate($term);
        $this->term_id = $newTerm->id;
        $this->term()->associate($newTerm);
        $this->setTaxonomy();

        return $this;
    }

    /**
     * Set parent category.
     *
     * @param int $parent_id
     *
     * @return \Orchid\Press\Models\Category
     */
    public function setParent($parent_id = 0): self
    {
        $this->parent_id = ((int) $parent_id > 0) ? (int) $parent_id : null;

        return $this;
    }
}
