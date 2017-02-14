<?php

namespace Orchid\Foundation\Core\Builders;

use Illuminate\Database\Eloquent\Builder;

class TermTaxonomyBuilder extends Builder
{
    /**
     * @var
     */
    private $slug;

    /**
     * Add posts to the relationship builder.
     *
     * @return \Orchid\Foundation\Core\Builders\TermTaxonomyBuilder
     */
    public function posts()
    {
        return $this->with('posts');
    }

    /**
     * Set taxonomy type to category.
     *
     * @return \Orchid\Foundation\Core\Builders\TermTaxonomyBuilder
     */
    public function category()
    {
        return $this->where('taxonomy', 'category');
    }

    /**
     * Get a term taxonomy by specific slug.
     *
     * @param string slug
     *
     * @return \Orchid\Foundation\Core\Builders\TermTaxonomyBuilder
     */
    public function slug($slug = null)
    {
        if (!is_null($slug) and !empty($slug)) {
            // set this slug to be used in with callback
            $this->slug = $slug;

            // exception to filter on specific slug
            $exception = function ($query) {
                $query->where('slug', '=', $this->slug);
            };

            // load term to filter
            return $this->whereHas('term', $exception);
        }

        return $this;
    }
}