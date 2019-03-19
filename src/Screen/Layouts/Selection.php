<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Repository;

/**
 * Class Selection.
 */
abstract class Selection extends Base
{
    /**
     * @var string
     */
    public $template = 'platform::container.layouts.selection';

    /**
     * @param Repository $query
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
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
     * @return array
     */
    abstract public function filters(): array;
}
