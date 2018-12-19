<?php

declare(strict_types=1);

namespace App\Orchid\Filters;

use Orchid\Platform\Models\Role;
use Orchid\Platform\Filters\Filter;
use Orchid\Screen\Fields\SelectField;
use Illuminate\Database\Eloquent\Builder;

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
        return $builder->whereHas('roles', function($query) {
            $query->where('slug', $this->request->get('role'));
        });
    }

    /**
     * @return mixed
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     */
    public function display()
    {
        return SelectField::make('role')
            ->options($this->getRoles())
            ->value($this->request->get('role'))
            ->title(__('Roles'))
            ->hr(false);
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return Role::select('slug', 'name')->pluck('name', 'slug');
    }
}
