<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Layouts;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;

class AnnouncementLayout extends Rows
{
    /**
     * @return array
     * @throws \Throwable
     */
    public function fields(): array
    {
        return [
            Field::tag('markdown')
                ->title('Предварительное оповещение о каком-либо событии.')
                ->type('text')
                ->name('announcement.content'),
        ];
    }
}
