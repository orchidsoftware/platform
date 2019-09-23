<?php

declare(strict_types=1);

namespace Orchid\Tests\Exemplar\App;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class EmptyUserModel.
 */
class EmptyUserModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAsBuilder(Builder $query) : Builder
    {
        return $query->where('name', 'RelationTest');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Support\Collection
     */
    public function scopeAsCollection(Builder $query) : Collection
    {
        return $query->where('name', 'RelationTest')->get();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return array
     */
    public function scopeAsArray(Builder $query): array
    {
        return $query->where('name', 'RelationTest')->get()->all();
    }
}
