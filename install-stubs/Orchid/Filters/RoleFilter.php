<?php

declare(strict_types=1);

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Platform\Filters\Filter;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Field;

class RoleFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = [
        'role',
    ];

    /**
     * @var bool
     */
    public $dashboard = true;

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder) : Builder
    {
        return $builder->whereHas('roles', function ($query) {
            $query->slug = $this->request->get('role');
        });
    }

    /**
     * @return mixed
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     */
    public function display()
    {
        $roles = Role::select('slug', 'name')->pluck('name', 'slug');

        return Field::tag('select')
            ->options($roles)
            ->name('role')
            ->title(trans('platform::systems/roles.title'))
            ->hr(false);
    }
}
