<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Layouts;

use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\SimpleMDEField;

class AnnouncementLayout extends Rows
{
    /**
     * @return array
     * @throws \Throwable
     */
    public function fields(): array
    {
        return [
            SimpleMDEField::make('announcement.content')
                ->type('text'),
        ];
    }
}
