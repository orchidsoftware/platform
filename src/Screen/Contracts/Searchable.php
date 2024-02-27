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

    public function searchQuery(?string $query = null): Builder;

    public function label(): string;

    public function title(): string;

    public function subTitle(): string;

    public function url(): string;

    /**
     * @return string
     */
    public function image(): ?string;
}
