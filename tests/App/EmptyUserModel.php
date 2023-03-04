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

    public function scopeAsBuilder(Builder $query): Builder
    {
        return $query->where('name', 'RelationTest');
    }

    public function scopeAsCollection(Builder $query): Collection
    {
        return $query->where('name', 'RelationTest')->get();
    }

    public function scopeAsArray(Builder $query): array
    {
        return $query->where('name', 'RelationTest')->get()->all();
    }

    public function getFullAttribute(): string
    {
        return $this->attributes['name'].' ('.$this->attributes['email'].')';
    }

    /**
     * @return Builder
     */
    public function scopeAsFilerId(Builder $query, int $id): Collection
    {
        return $query->where('id', $id)->get();
    }
}
