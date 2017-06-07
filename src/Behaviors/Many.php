<?php

namespace Orchid\Behaviors;

use Illuminate\Support\Collection;
use Illuminate\View\View;
use Orchid\Behaviors\Contract\ManyInterface;
use Orchid\Http\Filters\CreatedFilter;
use Orchid\Http\Filters\SearchFilter;
use Orchid\Http\Filters\StatusFilter;

abstract class Many implements ManyInterface
{
    use Structure;

    /**
     * Show the data to the user
     *
     * @var bool
     */
    public $display = true;

    /**
     * Is it possible to give data on api
     *
     * @var bool
     */
    public $api = false;

    /**
     * Eloquent Eager Loading
     *
     * @var array
     */
    public $with = [];

    /**
     * HTTP data filters
     *
     * @var array
     */
    public $filters = [
        SearchFilter::class,
        StatusFilter::class,
        CreatedFilter::class,
    ];

    /**
     * Registered fields for filling
     *
     * @return mixed
     */
    abstract public function fields();

    /**
     * Raw data and fields to display
     *
     * @return array
     */
    public function generateGrid(): array
    {
        $fields = $this->grid();

        $data = (new $this->model())->type($this->slug)
            ->filtersApplyDashboard($this->slug)
            ->with($this->with)
            ->orderBy('id', 'Desc')
            ->paginate();

        return [
            'data'   => $data,
            'fields' => $fields,
            'type'   => $this,
        ];
    }

    /**
     * Registered fields to display in the table
     *
     * @return mixed
     */
    abstract public function grid();

    /**
     * Display form for filtering
     *
     * @return View
     */
    public function showFilterDashboard(): View
    {
        $dashboardFilter = $this->getFilters(true);
        $chunk = ceil($dashboardFilter->count() / 4);

        return view('dashboard::container.posts.filter', [
            'filters' => $dashboardFilter,
            'chunk'   => $chunk,
        ]);
    }

    /**
     * Get all the filters
     *
     * @param bool $dashboard
     *
     * @return Collection
     */
    public function getFilters($dashboard = false): Collection
    {
        $filters = collect();
        foreach ($this->filters as $filter) {
            $filter = new $filter($this);
            if ($filter->dashboard == $dashboard) {
                $filters->push($filter);
            }
        }

        return $filters;
    }
}
