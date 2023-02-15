<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Fields;

use Orchid\Platform\Models\User;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Tests\App\Screens\BaseFieldScreen;

class BaseSelectScreen extends BaseFieldScreen
{
    /**
     * @return string[]
     */
    public function query(): array
    {
        return [
            'relationFromModelMultipleWithValue' => 1,
        ];
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function fields(): array
    {
        return [
            Select::make('choiceFromModel')
                ->fromModel(User::class, 'name'),

            Select::make('choiceEmptyOptions')
                ->options([]),

            Select::make('choiceOptions')
                ->options([
                    1 => 'One',
                    2 => 'Two',
                    3 => 'Three',
                ]),

            Select::make('choiceAssociativeOptions')
                ->options([
                    'red'     => 'Red',
                    'green'   => 'Green',
                    'blue'    => 'Blue',
                    'purple'  => 'Purple',
                    'magenta' => 'Magenta',
                ]),

            Select::make('choiceOptionsWithEmpty')
                ->empty()
                ->options([
                    1 => 'One',
                    2 => 'Two',
                    3 => 'Three',
                ]),

            Select::make('choiceOptionsWithEmptyName')
                ->empty('Select something')
                ->options([
                    1 => 'One',
                    2 => 'Two',
                    3 => 'Three',
                ]),

            Relation::make('relationFromModel')
                ->fromModel(User::class, 'name'),

            Relation::make('relationFromModelMultiple')
                ->multiple()
                ->fromModel(User::class, 'name'),

            Relation::make('relationFromModelMultipleAllowEmpty')
                ->multiple()
                ->allowEmpty()
                ->fromModel(User::class, 'name'),

            Relation::make('relationFromModelMultipleWithValue')
                ->multiple()
                ->fromModel(User::class, 'name'),
        ];
    }
}
