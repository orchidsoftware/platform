<?php

declare(strict_types=1);

namespace Orchid\Bulldozer\Layouts;

use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\InputField;

/**
 * Class BootCreateModel.
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
            InputField::make('name')
                ->title(__('Model name:'))
                ->help(__('Create a new model for your application'))
                ->pattern('^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$')
                ->hr(false)
                ->required(),
        ];
    }
}
