<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Repository;

/**
 * Class Selection
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
        $filters = $this->filters();

        if (count($filters) === 0) {
            return null;
        }

        return view($this->template, [
            'filters' => $filters,
        ]);
    }

    /**
     * @return array
     */
    public function filters(): array
    {
        return [];
    }
}