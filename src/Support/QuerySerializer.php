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
            'bindings' => $query->getBindings(),
            'model' => get_class($query->getModel()),
        ]);
    }

    public static function unserialize(string $data): Builder
    {
        $data = Crypt::decrypt($data);

        $model = new $data['model'];
        $query = $model->newQuery();

        $query->getQuery()->from($model->getTable())
        ->setBindings($data['bindings'])
        ->whereRaw($data['sql']);

        return $query;
    }

}