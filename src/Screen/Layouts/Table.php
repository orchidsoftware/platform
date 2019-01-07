<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Repository;

/**
 * Class Table.
 */
abstract class Table extends Base
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
        return view($this->template, [
            'data'    => $query->getContent($this->data),
            'fields'  => $this->fields(),
        ]);
    }

    /**
     * @return array
     */
    abstract public function fields(): array;
}
