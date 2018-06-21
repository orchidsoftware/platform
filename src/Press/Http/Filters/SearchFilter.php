<?php

declare(strict_types=1);

namespace Orchid\Press\Filters;

use Orchid\Screen\Fields\Field;
use Orchid\Platform\Filters\Filter;
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
     * @var bool
     */
    public $display = true;

    /**
     * @var bool
     */
    public $dashboard = true;

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder) : Builder
    {
        if ($builder->getQuery()->getConnection() instanceof PostgresConnection) {
            return $builder->whereRaw('content::TEXT ILIKE ?', '%'.$this->request->get('search').'%');
        }

        return $builder->where('content', 'LIKE', '%'.$this->request->get('search').'%');
    }

    /**
     * @return mixed
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     */
    public function display()
    {
        return Field::tag('input')
            ->type('text')
            ->name('search')
            ->value($this->request->get('search'))
            ->placeholder(trans('platform::common.search_posts'))
            ->title(trans('platform::common.filters.search'))
            ->maxlength(200)
            ->autocomplete('off')
            ->hr(false);
    }
}
