<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Filters;

use Orchid\Platform\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class CreatedFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = [
        'start_created_at',
        'end_created_at',
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
        return $builder->where('created_at', '>', $this->request->get('start_created_at'))->where('created_at', '<',
            $this->request->get('end_created_at'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed|void
     */
    public function display()
    {
        return view('dashboard::container.posts.filters.created', [
            'request' => $this->request,
        ]);
    }
}
