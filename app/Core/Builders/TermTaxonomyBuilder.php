<?php

namespace Orchid\Core\Builders;

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
     * @return \Orchid\Core\Builders\TermTaxonomyBuilder
     */
    public function posts(): TermTaxonomyBuilder
    {
        return $this->with('posts');
    }

    /**
     * Set taxonomy type to category.
     *
     * @return \Orchid\Core\Builders\TermTaxonomyBuilder
     */
    public function category(): TermTaxonomyBuilder
    {
        return $this->where('taxonomy', 'category');
    }

    /**
     * Set taxonomy type to nav_menu.
     *
     * @return mixed
     */
    public function menu()
    {
        return $this->where('taxonomy', 'menu');
    }

    /**
     * Get a term taxonomy by specific slug.
     *
     * @param string
     *
     * @return \Orchid\Core\Builders\TermTaxonomyBuilder
     */
    public function slug($slug = null): TermTaxonomyBuilder
    {
        if (!is_null($slug) && !empty($slug)) {
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
