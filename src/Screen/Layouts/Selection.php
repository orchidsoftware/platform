<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Filters\Filter;
use Orchid\Screen\Repository;
use Illuminate\Contracts\View\Factory;

/**
 * Class Selection.
 */
abstract class Selection extends Base
{
    /**
     * @var string
     */
    public $template = 'platform::layouts.selection';

    /**
     * @param Repository $query
     *
     * @return Factory|\Illuminate\View\View|mixed
     */
    public function build(Repository $query)
    {
        $filters = collect($this->filters());
        $count = $filters->count();

        if ($count === 0) {
            return;
        }

        foreach ($filters as $key => $filter) {
            $filters[$key] = new $filter();
        }

        return view($this->template, [
            'filters' => $filters,
            'chunk'   => ceil($count / 4),
        ]);
    }

    /**
     * @return Filter[]
     */
    abstract public function filters(): array;
}
