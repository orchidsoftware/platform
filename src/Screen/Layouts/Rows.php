<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Builder;
use Orchid\Screen\Repository;

/**
 * Class Rows.
 */
abstract class Rows extends Base
{
    /**
     * @var string
     */
    public $template = 'platform::container.layouts.row';

    /**
     * @var Repository
     */
    public $query;

    /**
     * @var int
     */
    protected $with = 100;

    /**
     * @param \Orchid\Screen\Repository $query
     *
     * @throws \Throwable
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function build(Repository $query)
    {
        $this->query = $query;
        $form = new Builder($this->fields(), $query);

        return view($this->template, [
            'with' => $this->with,
            'form' => $form->generateForm(),
        ]);
    }

    /**
     * @param int $with
     *
     * @return $this
     */
    public function with(int $with = 100) : Rows
    {
        $this->with = $with;

        return $this;
    }

    /**
     * @return array
     */
    abstract public function fields(): array;
}
