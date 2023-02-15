<?php

namespace Orchid\Tests\App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

class EmailFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = [
        'email',
    ];

    public function name(): string
    {
        return 'Email';
    }

    public function run(Builder $builder): Builder
    {
        return $builder->where('email', $this->request->get('email'));
    }

    /**
     * @return Field[]
     */
    public function display(): array
    {
        return [
            Input::make('email')
                ->value($this->request->get('name')),
        ];
    }
}
