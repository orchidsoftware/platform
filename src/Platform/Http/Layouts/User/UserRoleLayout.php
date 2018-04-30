<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Layouts\User;

use Orchid\Platform\Fields\Field;
use Orchid\Platform\Layouts\Rows;
use Illuminate\Support\Collection;

class UserRoleLayout extends Rows
{
    /**
     * Views.
     *
     * @throws \Orchid\Platform\Exceptions\TypeException
     *
     * @return array
     */
    public function fields(): array
    {
        $fields[] = Field::tag('select')
            ->options($this->query
                ->getContent('roles')
                ->where('active', true)
                ->pluck('name', 'slug')
                ->toArray())
            ->class('select2')
            ->multiple()
            ->name('roles[]')
            ->title(trans('dashboard::systems/users.roles'))
            ->placeholder(trans('dashboard::systems/users.select_roles'));

        $permissionFields = $this->generatedPermissionFields($this->query->getContent('permission'));

        return array_merge($fields, $permissionFields);
    }

    /**
     * @param Collection $permissionsRaw
     *
     * @throws \Orchid\Platform\Exceptions\TypeException
     *
     * @return array
     */
    public function generatedPermissionFields(Collection $permissionsRaw) : array
    {
        foreach ($permissionsRaw as $group => $items) {
            $fields[] = Field::tag('label')
                ->name($group)
                ->title($group)
                ->hr(false);

            foreach (collect($items)->chunk(3) as $chunks) {
                $fields[] = Field::group(function () use ($chunks) {
                    foreach ($chunks as $permission) {
                        $permissions[] = Field::tag('checkbox')
                            ->placeholder($permission['description'])
                            ->name('permissions.'.base64_encode($permission['slug']))
                            ->value((int) $permission['active'])
                            ->hr(false);
                    }

                    return $permissions ?? [];
                });
            }

            $fields[] = Field::tag('label')
                ->name('close');
        }

        return $fields ?? [];
    }
}
