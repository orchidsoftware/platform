<?php

namespace App\Orchid\Layouts\User;

use Orchid\Platform\Filters\Filter;
use Orchid\Screen\Layouts\Selection;
use App\Orchid\Filters\RoleFilter;

class UserFiltersLayout extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): array
    {
        return [
            RoleFilter::class,
        ];
    }
}
