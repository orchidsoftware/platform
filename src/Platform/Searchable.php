<?php

declare(strict_types=1);

namespace Orchid\Platform;

use Laravel\Scout\Builder;
use Laravel\Scout\Searchable as ScoutSearchable;

trait Searchable
{
    use ScoutSearchable;

    /**
     * The number of models to return for show compact search result.
     *
     * @var int
     */
    public $perSearchShow = 3;

    /**
     * @return string
     */
    public function searchLabel(): ?string
    {
        return $this->getAttribute('label') ?? static::class;
    }

    /**
     * @return string
     */
    public function searchTitle(): ?string
    {
        return $this->getAttribute('title')
            ?? 'See documentation method search* in Orchid\Platform\Searchable';
    }

    /**
     * @return string
     */
    public function searchSubTitle(): ?string
    {
        return $this->getAttribute('subTitle');
    }

    /**
     * @return string
     */
    public function searchUrl(): ?string
    {
        return $this->getAttribute('url') ?? '#';
    }

    /**
     * @return string
     */
    public function searchAvatar(): ?string
    {
        return $this->getAttribute('avatar');
    }

    /**
     * @param string $query
     *
     * @return Builder
     */
    public function searchQuery(string $query = null): Builder
    {
        return $this->search($query);
    }
}
