<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\PostgresConnection;
use Orchid\Platform\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\InputField;

class SearchFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = [
        'search',
    ];

    /**
     * @var bool
     */
    public $dashboard = true;

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
     * @return Field
     */
    public function display(): Field
    {
        return InputField::make('search')
            ->type('text')
            ->value($this->request->get('search'))
            ->placeholder(__('Search...'))
            ->title(__('Search'))
            ->maxlength(200)
            ->autocomplete('off');
    }
}
