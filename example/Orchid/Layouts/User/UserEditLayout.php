<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Layouts\Rows;
use Orchid\Platform\Models\User;

class UserEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return array
     *
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     */
    public function fields(): array
    {
        return User::getFieldsEdit()->all();
    }
}
