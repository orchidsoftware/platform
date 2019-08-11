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
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    public $target;

    /**
     * @param Repository $repository
     *
     * @return Factory|\Illuminate\View\View
     */
    public function build(Repository $repository)
    {
        if (! $this->checkPermission($this, $repository)) {
            return;
        }

        $columns = collect($this->fields())->filter(function (TD $item) {
            return $item->isSee();
        });

        return view($this->template, [
            'rows'         => $repository->getContent($this->target),
            'columns'      => $columns,
            'iconNotFound' => $this->iconNotFound(),
            'textNotFound' => $this->textNotFound(),
            'subNotFound'  => $this->subNotFound(),
        ]);
    }

    /**
     * @return string
     */
    public function iconNotFound(): string
    {
        return 'icon-table';
    }

    /**
     * @return string
     */
    public function textNotFound(): string
    {
        return __('Records not found');
    }

    /**
     * @return string
     */
    public function subNotFound(): string
    {
        return '';
    }

    /**
     * @return array
     */
    abstract public function fields(): array;
}
