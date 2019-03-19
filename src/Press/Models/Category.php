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
     * Set taxonomy.
     *
     * @return self
     */
    public function setTaxonomy() : self
    {
        $this['taxonomy'] = $this->taxonomy;

        return $this;
    }

    /**
     * Select all categories, except current.
     *
     * @return array
     */
    public function getAllCategories()
    {
        $categories = $this->exists ? self::whereNotIn('id', [$this->id])->get() : self::get();

        return $categories->mapWithKeys(function ($item) {
            return [$item->id => $item->term->GetContent('name')];
        })->toArray();
    }

    /**
     *  Create category term.
     *
     * @param array $term
     *
     * @return self
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
     * @param int|null $parent_id
     *
     * @return self
     */
    public function setParent($parent_id = null): self
    {
        $parent_id = ((int) $parent_id > 0) ? (int) $parent_id : null;

        $this->setAttribute('parent_id', $parent_id);

        return $this;
    }
}
