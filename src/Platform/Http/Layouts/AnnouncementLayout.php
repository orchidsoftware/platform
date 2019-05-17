<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Layouts;

use Throwable;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\SimpleMDE;

class AnnouncementLayout extends Rows
{
    /**
     * @throws Throwable
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            SimpleMDE::make('announcement.content')
                ->type('text'),
        ];
    }
}
