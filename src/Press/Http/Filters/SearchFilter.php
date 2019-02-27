<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Filters;

use Orchid\Screen\Field;
use Orchid\Platform\Filters\Filter;
use Orchid\Screen\Fields\Input;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\PostgresConnection;

class SearchFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = [
        'search',
    ];

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        if ($builder->getQuery()->getConnection() instanceof PostgresConnection) {
            return $builder->whereRaw('content::TEXT ILIKE ?', '%'.$this->request->get('search').'%');
        }

        return $builder->where('content', 'LIKE', '%'.$this->request->get('search').'%');
    }

    /**
     * @return Field
     */
    public function display(): Field
    {
        return Input::make('search')
            ->type('text')
            ->value($this->request->get('search'))
            ->placeholder(__('Search...'))
            ->title(__('Search'))
            ->maxlength(200)
            ->autocomplete('off');
    }
}
