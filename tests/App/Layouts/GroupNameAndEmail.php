<?php

namespace Orchid\Tests\App\Layouts;

use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;
use Orchid\Tests\App\Filters\EmailFilter;
use Orchid\Tests\App\Filters\NameFilter;

class GroupNameAndEmail extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): array
    {
        return [
            NameFilter::class,
            EmailFilter::class,
        ];
    }
}
