<?php

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;

abstract class TableConditional extends Layout{

    /**
     * @var string
     */
    protected $template = 'platform::layouts.table_conditional';

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
     * Table title.
     *
     * The string to be displayed on top of the table.
     *
     * @var string
     */
    protected $title;

    /**
     * Column name to check
     *
     * @var string
     */
    protected $condition;

    /**
     * Value of column to NOT apply row class to
     *
     * @var string
     */
    protected $value;

    /**
     * Class(es) for invalid rows
     *
     * @var string
     */
    protected $class;

    /**
     * @param Repository $repository
     *
     * @return Factory|\Illuminate\View\View
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return;
        }

        $columns = collect($this->columns())->filter(static function (TD $column) {
            return $column->isSee();
        });

        $total = collect($this->total())->filter(static function (TD $column) {
            return $column->isSee();
        });

        return view($this->template, [
            'repository'   => $repository,
            'rows'         => $repository->getContent($this->target),
            'columns'      => $columns,
            'total'        => $total,
            'iconNotFound' => $this->iconNotFound(),
            'textNotFound' => $this->textNotFound(),
            'subNotFound'  => $this->subNotFound(),
            'striped'      => $this->striped(),
            'bordered'     => $this->bordered(),
            'hoverable'    => $this->hoverable(),
            'slug'         => $this->getSlug(),
            'onEachSide'   => $this->onEachSide(),
            'title'        => $this->title,
            'condition'    => $this->condition,
            'value'        => $this->value,
            'class'        => $this->class,
        ]);
    }

    /**
     * @param string|null $title
     *
     * @return Table
     */
    public function title(string $title = null): self
    {
        $this->title = $title;

        return $this;
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
     * Usage for zebra-striping to any table row.
     *
     * @return bool
     */
    protected function striped(): bool
    {
        return false;
    }

    /**
     * Usage for borders on all sides of the table and cells.
     *
     * @return bool
     */
    protected function bordered(): bool
    {
        return false;
    }

    /**
     * Enable a hover state on table rows.
     *
     * @return bool
     */
    protected function hoverable(): bool
    {
        return false;
    }

    /**
     * The number of links to display on each side of current page link.
     *
     * @return int
     */
    protected function onEachSide(): int
    {
        return 3;
    }

    /**
     * @return array
     */
    abstract protected function columns(): array;

    /**
     * @return array
     */
    protected function total(): array
    {
        return [];
    }
}