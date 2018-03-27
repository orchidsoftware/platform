<?php

namespace Orchid\Platform\Http\Layouts\Role;

use Illuminate\Support\Collection;
use Orchid\Platform\Fields\Field;
use Orchid\Platform\Layouts\Rows;

class RoleEditLayout extends Rows
{
    /**
     * Views
     *
     * @return array
     * @throws \Orchid\Platform\Exceptions\TypeException
     */
    public function fields(): array
    {

        $fields =  [
            Field::tag('input')
                ->type('text')
                ->name('role.name')
                ->max(255)
                ->require()
                ->title(trans('dashboard::systems/roles.name'))
                ->placeholder(trans('dashboard::systems/roles.name'))
                ->help(trans('dashboard::systems/roles.name_help')),

            Field::tag('input')
                ->type('text')
                ->name('role.slug')
                ->max(255)
                ->require()
                ->title(trans('dashboard::systems/roles.slug'))
                ->placeholder(trans('dashboard::systems/roles.slug'))
                ->help(trans('dashboard::systems/roles.slug_help')),
            ];


        $permissionFields = $this->generatedPermissionFields($this->query->getContent('permission'));

        return array_merge($fields,$permissionFields);
    }

    /**
     * @param Collection $permissionsRaw
     *
     * @return array
     *
     * @throws \Orchid\Platform\Exceptions\TypeException
     */
    public function generatedPermissionFields(Collection $permissionsRaw) : array
    {

        $fields = [];

        foreach ($permissionsRaw as $group => $items) {

            $fields[] = Field::tag('label')
                ->name($group)
                ->title(trans('dashboard::permission.main.' . strtolower($group)))
                ->hr(false);

            foreach (collect($items)->chunk(4) as $chunks) {

                $fields[] = Field::group(function () use ($chunks) {
                    foreach ($chunks as $permission) {
                        $permissions[] = Field::tag('checkbox')
                            ->placeholder($permission['description'])
                            ->name("permissions." . base64_encode($permission['slug']))
                            ->modifyValue(function () use ($permission) {
                                return (int) $permission['active'];
                            })
                            ->hr(false);
                    }
                    return $permissions ?? [];
                });
            }

            $fields[] = Field::tag('label')
                ->name('close');
        }


        return $fields;
    }

}
