<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\TD;
use Orchid\Screen\Repository;
use Illuminate\Contracts\View\Factory;

/**
 * Class Table.
 */
abstract class Table extends Base
{
    /**
     * @var string
     */
    public $template = 'platform::layouts.table';

    /**
     * @var string
     */
    public $data;

    /**
     * @param Repository $query
     *
     * @return Factory|\Illuminate\View\View
     */
    public function build(Repository $query)
    {
        $columns = collect($this->fields())->filter(function (TD $item) {
            return $item->isSee();
        });

        return view($this->template, [
            'data'     => $query->getContent($this->data),
            'columns'  => $columns,
        ]);
    }

    /**
     * @return array
     */
    abstract public function fields(): array;
}
