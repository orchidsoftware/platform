<?php

namespace Orchid\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
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

        $query->fromSub(function (QueryBuilder $subQuery) use ($data) {
            $subQuery->from(DB::raw("({$data['sql']}) as sub"))
                ->addBinding($data['bindings'], 'select');
        }, 'sub');

        return $query;
    }
}