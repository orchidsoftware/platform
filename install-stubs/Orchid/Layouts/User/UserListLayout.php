<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Contents\Profile;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class UserListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'users';

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            TD::set('name', __('Name'))
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function (User $user) {
                    return new Profile($user->presenter());
                }),

            TD::set('email', __('Email'))
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function (User $user) {
                    return ModalToggle::make($user->email)
                        ->modal('oneAsyncModal')
                        ->modalTitle($user->getNameTitle())
                        ->method('saveUser')
                        ->asyncParameters($user->id);
                }),

            TD::set('updated_at', __('Last edit'))
                ->sort(),

            TD::set('id', 'ID')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (User $user) {
                    return DropDown::make()
                        ->icon('icon-options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.systems.users.edit', $user->id)
                                ->icon('icon-pencil'),

                            Button::make(__('Delete'))
                                ->method('remove')
                                ->confirm(__('Are you sure you want to delete the user?'))
                                ->parameters([
                                    'id' => $user->id,
                                ])
                                ->icon('icon-trash'),
                        ]);
                }),
        ];
    }
}
