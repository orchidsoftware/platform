<?php

declare(strict_types=1);

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Fields\Select;

class RoleFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return __('Roles');
    }

    public function parameters(): array
    {
        return ['role'];
    }

    public function run(Builder $builder): Builder
    {
        return $builder->whereHas(
            'roles',
            fn (Builder $query) => $query->where('id', $this->request->input('role'))
        );
    }

    /**
     * Get the display fields.
     *
     * @return list<Select>
     */
    public function display(): array
    {
        return [
            Select::make('role')
                ->fromModel(Role::class, 'name')
                ->empty()
                ->value($this->request->input('role'))
                ->title(__('Roles')),
        ];
    }

    /**
     * Value to be displayed
     */
    public function value(): string
    {
        $role = Role::find($this->request->input('role'));

        return $this->name().': '.($role->name ?? '');
    }
}
