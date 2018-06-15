<?php

declare(strict_types=1);

namespace Orchid\Press\Traits;

use Illuminate\Database\PostgresConnection;

trait SimpleSearch
{
    /**
     * @param      $column
     * @param null $query
     *
     * @return mixed
     */
    public function simpleSearchByColumn($column, $query = null)
    {
        if (static::getQuery()->getConnection() instanceof PostgresConnection) {
            return static::whereRaw("{$column}::TEXT ILIKE ?", "%{$query}%");
        }

        return static::where($column, 'LIKE', "%{$query}%");
    }
}
