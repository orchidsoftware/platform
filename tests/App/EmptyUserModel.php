<?php

declare(strict_types=1);

namespace Orchid\Tests\App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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
    public function scopeAsBuilder(Builder $query): Builder
    {
        return $query->where('name', 'RelationTest');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Support\Collection
     */
    public function scopeAsCollection(Builder $query): Collection
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

    /**
     * @return string
     */
    public function getFullAttribute(): string
    {
        return $this->attributes['name'].' ('.$this->attributes['email'].')';
    }
}
