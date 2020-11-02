<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Role;

use Illuminate\Support\Collection;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Rows;
use Throwable;

class RolePermissionLayout extends Rows
{
    /**
     * Views.
     *
     * @throws Throwable
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
        return $permissionsRaw->map(function ($items, $title) {
            return collect($items)
                ->map(function (array $chunks) {
                    return $this->getCheckBoxGroup(collect($chunks));
                })
                ->flatten()
                ->map(function (CheckBox $checkbox, $key) use ($title) {
                    return $key === 0
                        ? $checkbox->title($title)
                        : $checkbox;
                })
                ->chunk(4)
                ->map(function ($items) {
                    return Group::make($items->toArray())
                        ->alignEnd()
                        ->autoWidth();
                });
        })
            ->flatten()
            ->toArray();
    }

    /**
     * @param Collection $chunks
     *
     * @return CheckBox
     */
    private function getCheckBoxGroup(Collection $chunks): CheckBox
    {
        return CheckBox::make('permissions.' . base64_encode($chunks->get('slug')))
            ->placeholder($chunks->get('description'))
            ->value($chunks->get('active'))
            ->sendTrueOrFalse();
    }
}
