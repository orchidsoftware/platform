<?php

namespace Orchid\Behaviors;

use Illuminate\Support\Collection;
use Illuminate\View\View;
use Orchid\Behaviors\Contract\ManyInterface;

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
    public $filters = [];

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
        $dashboardFilter = $this->getFilterDashboard();
        $chunk = round($dashboardFilter->count() / 4);

        return view('dashboard::container.posts.filter', [
            'filters' => $dashboardFilter,
            'chunk'   => $chunk,
        ]);
    }

    /**
     * Get all the filters that need to be implemented in the control panel
     *
     * @return \Illuminate\Support\Collection
     */
    public function getFilterDashboard(): Collection
    {
        $dashboardFilter = collect();
        foreach ($this->filters as $filter) {
            $filter = new $filter;
            if ($filter->dashboard) {
                $dashboardFilter->push($filter);
            }
        }

        return $dashboardFilter;
    }
}
