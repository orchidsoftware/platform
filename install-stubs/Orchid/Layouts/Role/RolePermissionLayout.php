<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Role;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Illuminate\Support\Collection;
use Orchid\Screen\Fields\LabelField;
use Orchid\Screen\Fields\CheckBoxField;

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
            $fields[] = LabelField::make($group)
                ->title($group)
                ->hr(false);

            foreach (collect($items)->chunk(3) as $chunks) {
                $fields[] = Field::group(function () use ($chunks) {
                    foreach ($chunks as $permission) {
                        $permissions[] = CheckBoxField::make('permissions.'.base64_encode($permission['slug']))
                            ->placeholder($permission['description'])
                            ->value((int) $permission['active'])
                            ->hr(false);
                    }

                    return $permissions ?? [];
                });
            }

            $fields[] = LabelField::make('close');
        }

        return $fields ?? [];
    }
}
