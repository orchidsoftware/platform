<?php

declare(strict_types=1);

namespace Orchid\Filters;

abstract class BaseHttpEloquentFilter extends Filter
{
    /**
     * Constructor that initializes the filter with the specified column.
     *
     * @param string $column The database column that the filter will apply to.
     */
    public function __construct(protected string $column)
    {
        parent::__construct();
    }

    /**
     * Returns an array containing the matched filter parameters.
     *
     * This is used to map the column to its corresponding filter in the request.
     *
     * @return array|null The array containing the filter parameter name.
     */
    public function parameters(): ?array
    {
        return ['filter.'.$this->column];
    }

    /**
     * Retrieves the value of the filter from the HTTP request.
     *
     * @return mixed The value of the filter input from the request, or null if not present.
     */
    public function getHttpValue(): mixed
    {
        return $this->request->input('filter.'.$this->column);
    }
}
