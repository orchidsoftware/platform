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
                ->type('text')
                ->name('announcement.content'),
        ];
    }
}
