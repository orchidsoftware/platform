<?php

namespace Orchid\Platform\Layouts;

abstract class Table
{
    /**
     * @var string
     */
    public $template = 'dashboard::container.layouts.table';

    /**
     * @var string
     */
    public $data;

    /**
     * @param $post
     *
     * @return array
     * @throws \Throwable
     */
    public function build($post)
    {
        $form = $this->generatedTable($post);
        $filters = $this->showFilterDashboard();

        return view($this->template, [
            'form'    => $form,
            'filters' => $filters,
        ])->render();
    }

    /**
     * @return array
     */
    public function filters() : array
    {
        return [];
    }

    /**
     * @param $post
     *
     * @return array
     */
    private function generatedTable($post) : array
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

        return view('dashboard::container.layouts.filter', [
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
    public function fields() : array
    {
        return [];
    }
}
