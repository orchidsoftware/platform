<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Platform\Models\User;
use Orchid\Screen\Layouts\Table;
use App\Orchid\Filters\RoleFilter;

class UserListLayout extends Table
{
    /**
     * @var string
     */
    public $data = 'users';

    /**
     * HTTP data filters.
     *
     * @return array
     */
    public function filters() : array
    {
        return [
            RoleFilter::class,
        ];
    }

    /**
     * @return array
     */
    public function fields() : array
    {
        return User::getFieldsTable()->all();
    }
}
