<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\PostgresConnection;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

class SearchFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = [
        'search',
    ];

    /**
     * @return string
     */
    public function name(): string
    {
        return __('Search');
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        if ($builder->getQuery()->getConnection() instanceof PostgresConnection) {
            return $builder->whereRaw('content::TEXT ILIKE ?', '%' . $this->request->get('search') . '%');
        }

        return $builder->where('content', 'LIKE', '%' . $this->request->get('search') . '%');
    }

    /**
     * @return Field[]
     */
    public function display(): array
    {
        return [
            Input::make('search')
                ->type('text')
                ->value($this->request->get('search'))
                ->placeholder(__('Search...'))
                ->title($this->name())
                ->maxlength(200)
                ->autocomplete('off'),
        ];
    }
}
