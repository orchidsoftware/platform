<?php

declare(strict_types=1);

namespace Orchid\Tests\App;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    #[Scope]
    protected function asBuilder(Builder $query): Builder
    {
        return $query->where('name', 'RelationTest');
    }

    #[Scope]
    protected function asCollection(Builder $query): Collection
    {
        return $query->where('name', 'RelationTest')->get();
    }

    #[Scope]
    protected function asArray(Builder $query): array
    {
        return $query->where('name', 'RelationTest')->get()->all();
    }

    /**
     * @return Attribute<string, never>
     */
    protected function full(): Attribute
    {
        return Attribute::make(get: function () {
            return $this->attributes['name'].' ('.$this->attributes['email'].')';
        });
    }

    #[Scope]
    protected function asFilerId(Builder $query, int $id): Collection
    {
        return $query->where('id', $id)->get();
    }
}
