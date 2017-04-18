<?php

namespace Orchid\Core\Builders;

use Illuminate\Database\Eloquent\Builder;

class PostBuilder extends Builder
{
    /**
     * Get only published posts.
     *
     * @return \Orchid\Core\Builders\PostBuilder
     */
    public function published() : PostBuilder
    {
        return $this->status('publish');
    }

    /**
     * Get only posts with a custom status.
     *
     * @param string $postStatus
     *
     * @return \Orchid\Core\Builders\PostBuilder
     */
    public function status($postStatus) : PostBuilder
    {
        return $this->where('status', $postStatus);
    }

    /**
     * Get only posts from a custom post type.
     *
     * @param string $type
     *
     * @return \Orchid\Core\Builders\PostBuilder
     */
    public function type($type) : PostBuilder
    {
        return $this->where('type', $type);
    }

    /**
     * Get only posts from an array of custom post types.
     *
     * @param array $type
     *
     * @return \Orchid\Core\Builders\PostBuilder
     */
    public function typeIn(array $type) : PostBuilder
    {
        return $this->whereIn('type', $type);
    }

    /**
     * @param string $taxonomy
     * @param mixed  $term
     *
     * @return Builder|static
     */
    public function taxonomy($taxonomy, $term) : Builder
    {
        return $this->whereHas('taxonomies', function ($query) use ($taxonomy, $term) {
            $query->where('taxonomy', $taxonomy)->whereHas('term', function ($query) use ($term) {
                $query->where('slug', $term);
            });
        });
    }

    /**
     * Get only posts with a specific slug.
     *
     * @param string $slug
     *
     * @return \Orchid\Core\Builders\PostBuilder
     */
    public function slug($slug) : PostBuilder
    {
        return $this->where('slug', $slug);
    }
}
