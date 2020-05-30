<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Role;

use Illuminate\Support\Collection;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Layouts\Rows;

class RolePermissionLayout extends Rows
{
    /**
     * Views.
     *
     * @throws \Throwable
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
     * @return array
     */
    private function generatedPermissionFields(Collection $permissionsRaw): array
    {
        return $permissionsRaw->map(function ($items, $group) {
            return collect($items)
                ->chunk(3)
                ->map(function (Collection $chunks) {
                    return Group::make($this->getCheckBoxGroup($chunks))->autoWidth();
                })
                ->prepend(Label::make($group)->title($group));
        })
            ->flatten()
            ->toArray();
    }

    /**
     * @param Collection $chunks
     *
     * @return array
     */
    private function getCheckBoxGroup(Collection $chunks): array
    {
        return $chunks->map(function ($permission) {
            return CheckBox::make('permissions.'.base64_encode($permission['slug']))
                ->placeholder($permission['description'])
                ->value($permission['active'])
                ->sendTrueOrFalse();
        })->toArray();
    }
}
