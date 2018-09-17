<?php

declare(strict_types=1);

namespace Orchid\Savior\Http\Layouts;

use Orchid\Screen\Fields\Field;
use Orchid\Screen\Layouts\Rows;

class AnnouncementLayout extends Rows
{
    /**
     * Views
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Field::tag('markdown')
                ->type('text')
                ->name('category.content.name')
        ];
    }
}
