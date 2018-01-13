<?php

namespace Orchid\Platform\Behaviors;

use Illuminate\View\View;
use Illuminate\Support\Collection;
use Orchid\Platform\Http\Filters\SearchFilter;
use Orchid\Platform\Http\Filters\StatusFilter;
use Orchid\Platform\Http\Filters\CreatedFilter;
use Orchid\Platform\Behaviors\Contract\ManyInterface;

abstract class Many implements ManyInterface
{
    use Structure;

    /**
     * Show the data to the user.
     *
     * @var bool
     */
    public $display = true;

    /**
     * Is it possible to give data on api.
     *
     * @var bool
     */
    public $api = false;

    /**
     * Eloquent Eager Loading.
     *
     * @var array
     */
    public $with = [];

    /**
     * Registered fields for filling.
     *
     * @return mixed
     */
    abstract public function fields() : array;

    /**
     * Raw data and fields to display.
     *
     * @return array
     */
    public function generateGrid() : array
    {
        $fields = $this->grid();

        $data = (new $this->model())->type($this->slug)->filtersApplyDashboard($this->slug)->with($this->with)->orderBy('id',
            'Desc')->paginate();

        return [
            'data'   => $data,
            'fields' => $fields,
            'type'   => $this,
        ];
    }

    /**
     * Registered fields to display in the table.
     *
     * @return array
     */
    abstract public function grid() : array;

    /**
     * Display form for filtering.
     *
     * @return View
     */
    public function showFilterDashboard() : View
    {
        $dashboardFilter = $this->getFilters(true);
        $chunk = ceil($dashboardFilter->count() / 4);

        return view('dashboard::container.posts.filter', [
            'filters' => $dashboardFilter,
            'chunk'   => $chunk,
        ]);
    }

    /**
     * Get all the filters.
     *
     * @param bool $dashboard
     *
     * @return Collection
     */
    public function getFilters($dashboard = false) : Collection
    {
        $filters = collect();
        foreach ($this->filters() as $filter) {
            $filter = new $filter($this);
            if ($filter->dashboard == $dashboard) {
                $filters->push($filter);
            }
        }

        return $filters;
    }

    /**
     * HTTP data filters.
     *
     * @return array
     */
    public function filters() : array
    {
        return [
            SearchFilter::class,
            StatusFilter::class,
            CreatedFilter::class,
        ];
    }
}
