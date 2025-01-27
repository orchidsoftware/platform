<?php

declare(strict_types=1);

namespace Orchid\Platform\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait Sortable
{
    /**
     * Get the column name for sorting.
     *
     * @return string
     */
    public function getSortColumnName(): string
    {
        return 'order';
    }

    /**
     * Get the value of the sorting column.
     *
     * @return int|null
     */
    public function getSortColumnValue(): ?int
    {
        return $this->{$this->getSortColumnName()};
    }

    /**
     * Set the sort column value.
     *
     * @param int $sortOrder The new sort column value.
     *
     * @return $this
     */
    public function setSortColumn(int $sortOrder): static
    {
        $this->{$this->getSortColumnName()} = $sortOrder;

        return $this;
    }

    /**
     * Scope a query to sort the results by the sort column.
     *
     * @param Builder $query
     * @param string  $direction The sorting direction (ASC or DESC). Default is ASC.
     *
     * @return Builder
     */
    public function scopeSorted(Builder $query, string $direction = 'ASC'): Builder
    {
        $column = $this->getSortColumnName();

        return $query->orderBy($column, $direction);
    }
}
