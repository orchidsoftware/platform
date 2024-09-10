<?php

namespace Orchid\Tests\App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Autofill;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

class AutofillFilter extends Filter
{
    use Autofill;

    /**
     * @var array
     */
    public $parameters = [
        'value', 'inner.value',
    ];

    public function name(): string
    {
        return 'Autofill';
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
        return [
            Input::make('value'),
            Input::make('inner.value'),
        ];
    }
}
