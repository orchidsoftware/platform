<?php

namespace Orchid\Tests\App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;

class HiddenFilter extends Filter
{
    /**
     * @var bool
     */
    public $display = false;

    /**
     * @var array
     */
    public $parameters = [];

    public function name(): string
    {
        return '';
    }

    public function run(Builder $builder): Builder
    {
        return $builder;
    }

    /**
     * @return Field[]
     */
    public function display(): array
    {
        return [];
    }
}
