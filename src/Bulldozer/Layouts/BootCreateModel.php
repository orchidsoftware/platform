<?php

declare(strict_types=1);

namespace Orchid\Bulldozer\Layouts;

use Orchid\Screen\Fields\Field;
use Orchid\Screen\Layouts\Rows;

/**
 * Class BootCreateModel
 */
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
                ->pattern('^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$')
                ->required(),
        ];
    }
}
