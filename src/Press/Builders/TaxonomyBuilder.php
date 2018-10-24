<?php

declare(strict_types=1);

namespace Orchid\Press\Builders;

use Illuminate\Database\Eloquent\Builder;

class TaxonomyBuilder extends Builder
{
    /**
     * @var
     */
    private $slug;

    /**
     * Add posts to the relationship builder.
     *
     * @return \Orchid\Press\Builders\TaxonomyBuilder
     */
    public function posts() : self
    {
        return $this->with('posts');
    }

    /**
     * Set taxonomy type to category.
     *
     * @return \Orchid\Press\Builders\TaxonomyBuilder
     */
    public function category() : self
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
     * @return \Orchid\Press\Builders\TaxonomyBuilder
     */
    public function slug($slug = null) : self
    {
        if (! empty($slug)) {
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
