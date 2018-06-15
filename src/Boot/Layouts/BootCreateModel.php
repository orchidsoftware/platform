<?php

declare(strict_types=1);

namespace Orchid\Boot\Layouts;

use Orchid\Screen\Fields\Field;
use Orchid\Screen\Layouts\Rows;

class BootCreateModel extends Rows
{
    /**
     * Views.
     *
     * @return array
     * @throws \Throwable
     */
    public function fields(): array
    {
        return [
            Field::tag('input')
                ->title('Model Name:')
                ->help('Create a new model for your application')
                ->name('name')
                ->required(),
        ];
    }
}
