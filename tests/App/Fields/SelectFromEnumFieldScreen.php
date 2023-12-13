<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Fields;

use Orchid\Screen\Fields\Select;
use Orchid\Tests\App\Role;
use Orchid\Tests\App\Screens\BaseFieldScreen;

class SelectFromEnumFieldScreen extends BaseFieldScreen
{
    /**
     * @return string[]
     */
    public function query(): array
    {
        return [
            'item' => Role::find(1),
        ];
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function fields(): array
    {
        return [
            Select::make('item.name')
                ->options([
                    'admin' => 'Admin',
                    'user'  => 'User',
                ]),

        ];
    }
}
