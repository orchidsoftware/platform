<?php

declare(strict_types=1);

namespace Orchid\Screen\Contracts;

use Laravel\Scout\Builder;

interface Searchable
{
    /**
     * The number of models to return for a show compact search result.
     */
    public function perSearchShow(): int;

    /**
     * Build the query used to retrieve matching search results.
     */
    public function searchQuery(?string $query = null): Builder;

    /**
     * Return the label used to group search results.
     */
    public function label(): string;

    /**
     * Return the search result title.
     */
    public function title(): string;

    /**
     * Return the secondary text for the search result.
     */
    public function subTitle(): string;

    /**
     * Return the search result destination URL.
     */
    public function url(): string;

    /**
     * @return string
     */
    public function image(): ?string;
}
