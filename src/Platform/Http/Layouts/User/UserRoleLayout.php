<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Layouts\User;

use Orchid\Screen\Fields\Field;
use Orchid\Screen\Layouts\Rows;
use Illuminate\Support\Collection;

class UserRoleLayout extends Rows
{
    /**
     * Views.
     *
     * @return array
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     */
    public function fields(): array
    {
        $fields[] = Field::tag('select')
            ->options($this->query
                ->getContent('roles')
                ->pluck('name', 'slug')
                ->toArray())
            ->value(function () {
                return $this->query
                    ->getContent('roles')
                    ->where('active', true)
                    ->pluck('name', 'slug')
                    ->toArray();
            })
            ->class('select2')
            ->multiple()
            ->name('roles[]')
            ->title(trans('platform::systems/users.roles'))
            ->placeholder(trans('platform::systems/users.select_roles'));

        $permissionFields = $this->generatedPermissionFields($this->query->getContent('permission'));
        return array_merge($fields, $permissionFields);
    }

    /**
     * @param Collection $permissionsRaw
     *
     * @return array
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
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
