<?php namespace Orchid\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;

class CreatedFilter extends Filter
{

    /**
     *
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
    public function run(Builder $builder): Builder
    {
        return $builder->where('created_at', '>', $this->request->get('start_created_at'))
            ->where('created_at', '<', $this->request->get('end_created_at'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function display()
    {
        return view('dashboard::container.posts.filters.created', [
            'request' => $this->request,
        ]);
    }
}
