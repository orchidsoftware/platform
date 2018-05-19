<?php

declare(strict_types=1);

namespace Orchid\Platform\Layouts;

use Orchid\Platform\Fields\Builder;
use Orchid\Platform\Screen\Repository;

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
     * @param $query
     *
     * @throws \Throwable
     *
     * @return array
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
