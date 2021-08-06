<?php

namespace Orchid\Tests\App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;

class EmailFilter extends Filter
{
    /**
     * @var bool
     */
    public $display = false;

    /**
     * @var array
     */
    public $parameters = [
        'email',
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
        return $builder->where('email', $this->request->get('email'));
    }

    /**
     * @return Field[]
     */
    public function display(): array
    {
        return [];
    }
}
