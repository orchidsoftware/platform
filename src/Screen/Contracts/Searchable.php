<?php

declare(strict_types=1);

namespace Orchid\Screen\Contracts;

use Laravel\Scout\Builder;

interface Searchable
{
    /**
     * The number of models to return for show compact search result.
     *
     * @return int
     */
    public function perSearchShow(): int;

    /**
     * @param string|null $query
     *
     * @return Builder
     */
    public function searchQuery(string $query = null): Builder;

    /**
     * @return string
     */
    public function label(): string;

    /**
     * @return string
     */
    public function title(): string;

    /**
     * @return string
     */
    public function subTitle(): string;

    /**
     * @return string
     */
    public function url(): string;

    /**
     * @return string
     */
    public function image(): ?string;
}
