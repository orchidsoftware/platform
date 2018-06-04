<?php

declare(strict_types=1);

namespace Orchid\Boot\Layouts;

use Orchid\Platform\Fields\Field;
use Orchid\Platform\Layouts\Rows;

class BootCreateModel extends Rows
{
    /**
     * Views
     *
     * @return array
     * @throws \Orchid\Platform\Exceptions\TypeException
     */
    public function fields(): array
    {
        return [
            Field::tag('input')
                ->title('Model Name:')
                ->help('Create a new model for your application')
                ->name('name')
                ->required()
        ];
    }
}
