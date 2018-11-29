<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Layouts;

use Orchid\Screen\Fields\SimpleMDEField;
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
            SimpleMDEField::make('announcement.content')
                ->type('text'),
        ];
    }
}
