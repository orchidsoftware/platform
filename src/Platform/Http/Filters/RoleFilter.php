<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Filters;

use Orchid\Platform\Fields\Field;
use Orchid\Platform\Filters\Filter;
use Orchid\Platform\Core\Models\Role;
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
    public $display = true;

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
     * @throws \Orchid\Platform\Exceptions\TypeException
     *
     * @return mixed|void
     */
    public function display()
    {
        $roles = Role::select('slug', 'name')->pluck('name', 'slug');
        $selectRole = $this->request->get('role');

        return Field::tag('select')
            ->options($roles)
            ->name('role')
            ->title('Roles')
            ->hr(false);
        //->modifyValue($selectRole);
    }
}
