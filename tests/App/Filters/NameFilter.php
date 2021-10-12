<?php

namespace Orchid\Tests\App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

class NameFilter extends Filter
{
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
        return 'Name';
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
        return [
            Input::make('name')
                ->value($this->request->get('name')),
        ];
    }
}
