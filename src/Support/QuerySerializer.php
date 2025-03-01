<?php

namespace Orchid\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class QuerySerializer
{
    /**
     * Serialize Eloquent Builder to array.
     *
     * @param Builder $query
     * @return string
     */
    public static function serialize(Builder $query): string
    {
        return Crypt::encrypt([
            'sql' => $query->toSql(),
            'model' => get_class($query->getModel()),
            'limit' => $query->getQuery()->limit,
        ]);
    }

    /**
     * Unserialize array to Eloquent Builder.
     *
     * @param string $data
     * @return Builder
     */
    public static function unserialize(string $data): Builder
    {
        $data = Crypt::decrypt($data);

        $model = new $data['model'];
        $query = $model->newQuery();

        $query->raw($data['sql']);

        if (isset($data['limit'])) {
            $query->take($data['limit']);
        }

        return $query;
    }
}