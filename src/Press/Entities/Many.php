<?php

declare(strict_types=1);

namespace Orchid\Press\Entities;

use Illuminate\View\View;
use Orchid\Press\Models\Post;
use Illuminate\Support\Collection;
use Orchid\Screen\Fields\InputField;
use Orchid\Screen\Fields\SelectField;
use Orchid\Screen\Fields\DateTimerField;
use Illuminate\Contracts\Pagination\Paginator;

abstract class Many implements EntityContract
{
    use Structure, Actions;

    /**
     * Eloquent Eager Loading.
     *
     * @var array
     */
    public $with = [];

    /**
     * @var null
     */
    public $slugFields;

    /**
     * Registered fields to display in the table.
     *
     * @return array
     */
    abstract public function grid(): array;

    /**
     * HTTP data filters.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }

    /**
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function get(): Paginator
    {
        return Post::type($this->slug)
            ->filtersApplyDashboard($this->slug)
            ->filters()
            ->with($this->with)
            ->orderBy('id', 'Desc')
            ->paginate();
    }

    /**
     * Raw data and fields to display.
     *
     * @return array
     */
    public function generateGrid(): array
    {
        return [
            'data' => $this->get(),
            'fields' => $this->grid(),
            'type' => $this,
        ];
    }

    /**
     * Display form for filtering.
     *
     * @return View
     */
    public function showFilterDashboard(): View
    {
        $dashboardFilter = $this->getFilters(true);
        $chunk = ceil($dashboardFilter->count() / 4);

        return view('platform::container.posts.filter', [
            'filters' => $dashboardFilter,
            'chunk' => $chunk,
        ]);
    }

    /**
     * Get all the filters.
     *
     * @param bool $dashboard
     *
     * @return Collection
     */
    public function getFilters($dashboard = false): Collection
    {
        $filters = collect();
        foreach ($this->filters() as $filter) {
            $filter = new $filter($this);
            if ($filter->dashboard === $dashboard) {
                $filters->push($filter);
            }
        }

        return $filters;
    }

    /**
     * Registered fields for main.
     *
     * @return array
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     */
    public function main(): array
    {
        return [
            InputField::make('slug')
                ->type('text')
                ->name('slug')
                ->max(255)
                ->title(__('Semantic URL'))
                ->placeholder(__('Unique name')),

            DateTimerField::make('publish_at')
                ->title(__('Time of publication')),

            SelectField::make('status')
                ->options($this->status())
                ->title(__('Status')),
        ];
    }
}
