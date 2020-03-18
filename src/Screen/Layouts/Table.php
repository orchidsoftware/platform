<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;

/**
 * Class Table.
 */
abstract class Table extends Base
{
    /**
     * @var string
     */
    protected $template = 'platform::layouts.table';

    /**
     * @var Repository
     */
    protected $query;

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target;

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

        $this->query = $repository;

        $columns = collect($this->columns())->filter(static function (TD $column) {
            return $column->isSee();
        });

        return view($this->template, [
            'rows'         => $repository->getContent($this->target),
            'columns'      => $columns,
            'iconNotFound' => $this->iconNotFound(),
            'textNotFound' => $this->textNotFound(),
            'subNotFound'  => $this->subNotFound(),
            'striped'      => $this->striped(),
            'slug'         => $this->getSlug(),
        ]);
    }

    /**
     * @return string
     */
    protected function iconNotFound(): string
    {
        return 'icon-table';
    }

    /**
     * @return string
     */
    protected function textNotFound(): string
    {
        return __('There are no records in this view');
    }

    /**
     * @return string
     */
    protected function subNotFound(): string
    {
        return '';
    }

    /**
     * @return bool
     */
    protected function striped(): bool
    {
        return false;
    }

    /**
     * @return array
     */
    abstract protected function columns(): array;
}
