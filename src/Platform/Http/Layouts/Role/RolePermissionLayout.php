<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Layouts\Role;

use Illuminate\Support\Collection;
use Orchid\Platform\Fields\Field;
use Orchid\Platform\Layouts\Rows;

class RolePermissionLayout extends Rows
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
        return $this->generatedPermissionFields($this->query->getContent('permission'));
    }

    /**
     * @param Collection $permissionsRaw
     *
     * @throws \Orchid\Platform\Exceptions\TypeException
     *
     * @return array
     */
    public function generatedPermissionFields(Collection $permissionsRaw): array
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

        return $fields ?? [];
    }
}
