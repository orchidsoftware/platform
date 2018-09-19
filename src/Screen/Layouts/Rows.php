<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Repository;
use Orchid\Screen\Builder;

/**
 * Class Rows.
 */
abstract class Rows
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
     * @param \Orchid\Screen\Repository $query
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function build(Repository $query)
    {
        $this->query = $query;
        $form = new Builder($this->fields(), $query);

        return view($this->template, [
            'form' => $form->generateForm(),
        ]);
    }

    /**
     * @return array
     */
    public function fields(): array
    {
        return [];
    }
}
