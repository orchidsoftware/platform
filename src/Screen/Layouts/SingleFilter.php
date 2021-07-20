<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
use Orchid\Filters\Filter;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Selection.
 */
abstract class SingleFilter extends Layout
{
    /**
     * Drop down filters.
     */
    //ublic const TEMPLATE_DROP_DOWN = 'platform::layouts.selection';

    /**
     * Line filters.
     */
    //public const TEMPLATE_LINE = 'platform::layouts.filter';

    /**
     * @var string
     */
    public $template = 'platform::layouts.filter';

    /**
     * @param Repository $repository
     *
     * @return Factory|\Illuminate\View\View|mixed
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return;
        }

        $filter = collect($this->filter());
        $filter[0]->display = true;
        return view($this->template, [
            'filters' => $filter,
            'chunk'   => 1.0,
        ]);
    }

    /**
     * @return Filter[]
     */
    abstract public function filter(): array;
}
