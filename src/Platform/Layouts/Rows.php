<?php

declare(strict_types=1);

namespace Orchid\Platform\Layouts;

use Orchid\Platform\Fields\Builder;

abstract class Rows
{
    /**
     * @var string
     */
    public $template = 'dashboard::container.layouts.row';

    /**
     * @var
     */
    public $query;

    /**
     * @param $query
     *
     * @return array
     * @throws \Throwable
     */
    public function build($query)
    {
        $this->query = $query;
        $form = new Builder($this->fields(), $query);

        return view($this->template, [
            'form' => $form->generateForm(),
        ])->render();
    }

    /**
     * @return array
     */
    public function fields() : array
    {
        return [];
    }
}
