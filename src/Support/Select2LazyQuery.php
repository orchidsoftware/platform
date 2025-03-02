<?php

namespace Orchid\Support;

use Composer\InstalledVersions;
use Composer\Semver\VersionParser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class Select2LazyQuery
{
    /**
     * Prepare and Serialize Eloquent Builder to encrypted string.
     *
     * @param Builder $query
     * @param string $name
     * @param array|null $searchColumns
     * @return string
     */
    public static function prepare(Builder $query, string $name, array $searchColumns = null): string
    {
        if (InstalledVersions::satisfies(new VersionParser, 'laravel/framework', '>11.17.0')) {
            $query = $query->where(function ($query) use ($name, $searchColumns) {
                $query->whereLike($name, ':search');

                $query->when($searchColumns !== null, function ($query) use ($searchColumns) {
                    foreach ($searchColumns as $column) {
                        $query->orWhereLike($column, ':search');
                    }
                });
            });
        } else {
            $query = $query->where(function ($query) use ($name, $searchColumns) {
                $query->where($name, 'like', ':search');

                $query->when($searchColumns !== null, function ($query) use ($searchColumns) {
                    foreach ($searchColumns as $column) {
                        $query->orWhere($column, 'like', ':search');
                    }
                });
            });
        }

        $model = $query->getModel();
        $table = $model->getTable();

        $conditions = Str::after($query->toSql(), "select * from \"$table\" where");

        return Crypt::encrypt([
            'conditions' => $conditions,
            'bindings' => $query->getBindings(),
            'model' => get_class($model),
        ]);
    }

    /**
     * Deserialize encrypted string back to Eloquent Builder and replace search value.
     *
     * @param string $data
     * @param string|null $search
     * @return Builder
     */
    public static function execute(string $data, string $search = null): Builder
    {
        $data = Crypt::decrypt($data);

        $data['bindings'] = collect($data['bindings'])->map(function($value) use ($search) {
            return $value === ':search' ? "%$search%" : $value;
        })->all();

        $model = new $data['model'];
        return $model->newQuery()
            ->whereRaw($data['conditions'], $data['bindings']);
    }
}
