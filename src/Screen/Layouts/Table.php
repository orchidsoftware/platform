<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Repository;

/**
 * Class Table
 */
abstract class Table
{
    /**
     * @var string
     */
    public $template = 'platform::container.layouts.table';

    /**
     * @var string
     */
    public $data;

    /**
     * @param \Orchid\Screen\Repository $query
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function build(Repository $query)
    {
        $form = $this->generatedTable($query);
        $filters = $this->showFilterDashboard();

        return view($this->template, [
            'form'    => $form,
            'filters' => $filters,
        ]);
    }

    /**
     * @param $post
     *
     * @return array
     */
    private function generatedTable(Repository $post): array
    {
        return [
            'data'   => $post->getContent($this->data),
            'fields' => $this->fields(),
        ];
    }

    /**
     * Display form for filtering.
     *
     * @return View
     */
    public function showFilterDashboard()
    {
        $dashboardFilter = $this->getFilters(true);
        $chunk = ceil($dashboardFilter->count() / 4);

        return view('platform::container.layouts.filter', [
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
    public function getFilters($dashboard = false)
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
     * @return array
     */
    public function filters() : array
    {
        return [];
    }

    /**
     * @return array
     */
    public function fields() : array
    {
        return [];
    }
}
