<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Role;

use Illuminate\Support\Collection;
use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;

class RolePermissionLayout extends Rows
{
    /**
     * Views.
     *
     * @return array
     * @throws \Throwable
     */
    public function fields(): array
    {
        return $this->generatedPermissionFields($this->query->getContent('permission'));
    }

    /**
     * @param Collection $permissionsRaw
     *
     * @return array
     * @throws \Throwable
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
