<?php

declare(strict_types=1);

namespace Orchid\Filters\Types;

use Composer\InstalledVersions;
use Composer\Semver\VersionParser;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\BaseHttpEloquentFilter;

class Like extends BaseHttpEloquentFilter
{
    public function run(Builder $builder): Builder
    {
        $value = '%'.$this->getHttpValue().'%';

        if (InstalledVersions::satisfies(new VersionParser, 'laravel/framework', '>11.17.0')) {
            return $builder->whereLike($this->column, $value);
        }

        /**
         * @deprecated logic for older Laravel versions
         */
        return $builder->where($this->column, 'like', $value);
    }
}
