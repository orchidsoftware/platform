<?php

namespace Orchid\Platform\Http\Filters;

use Illuminate\Database\PostgresConnection;
use Orchid\Platform\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

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
            return $builder->whereRaw("content::TEXT ILIKE ?",'%'.$this->request->get('search').'%');
        }

        return $builder->where('content', 'LIKE', '%'.$this->request->get('search').'%');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function display()
    {
        return view('dashboard::container.posts.filters.search', [
            'request' => $this->request,
        ]);
    }
}
