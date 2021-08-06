<?php

namespace Orchid\Tests\App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;

class NameFilter extends Filter
{
    /**
     * @var bool
     */
    public $display = false;

    /**
     * @var array
     */
    public $parameters = [
        'name',
    ];

    /**
     * @return string
     */
    public function name(): string
    {
        return '';
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where('name', $this->request->get('name'));
    }

    /**
     * @return Field[]
     */
    public function display(): array
    {
        return [];
    }
}
