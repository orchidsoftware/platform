<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Role;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;

class RoleListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'roles';

    /**
     * @return array
     */
    public function columns() : array
    {
        return [
            TD::set('name', __('Name'))
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->link('platform.systems.roles.edit', 'slug', 'name'),

            TD::set('slug', __('Slug'))
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->link('platform.systems.roles.edit', 'slug', 'name'),

            TD::set('created_at', __('Created'))
                ->sort(),

            TD::set('id', 'ID')
                ->sort()
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->link('platform.systems.roles.edit', 'slug'),
        ];
    }
}
