<?php

declare(strict_types=1);

namespace Orchid\Platform;

use Laravel\Scout\Searchable as ScoutSearchable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait Searchable
{
    use ScoutSearchable;

    /**
     * @return string
     */
    public function searchLabel(): ?string
    {
        return $this->getAttribute('label');
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
     * @return LengthAwarePaginator
     */
    public function searchQuery(string $query = null): LengthAwarePaginator
    {
        return $this->search($query)->paginate(5);
    }
}
