<?php

declare(strict_types=1);

namespace App\Orchid\Filters;

use Orchid\Screen\Field;
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
        return $builder->whereHas('roles', function ($query) {
            $query->where('slug', $this->request->get('role'));
        });
    }

    /**
     * @return Field|null
     */
    public function display() : ?Field
    {
        return SelectField::make('role')
            ->options($this->getRoles())
            ->value($this->request->get('role'))
            ->title(__('Roles'));
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return Role::select('slug', 'name')->pluck('name', 'slug');
    }
}
