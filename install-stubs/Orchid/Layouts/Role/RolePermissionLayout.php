<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Role;

use Illuminate\Support\Collection;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
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
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     *
     * @return array
     */
    public function generatedPermissionFields(Collection $permissionsRaw): array
    {
        $fields = [];

        $permissionsRaw->each(function ($items, $group) use (&$fields) {
            $fields[] = Label::make($group)->title($group);

            collect($items)
                ->chunk(3)
                ->each(function (Collection $chunks) use (&$fields) {
                    $fields[] = Field::group(function () use ($chunks) {
                        return $chunks->map(function ($permission) {
                            return CheckBox::make('permissions.'.base64_encode($permission['slug']))
                                ->placeholder($permission['description'])
                                ->value($permission['active'])
                                ->sendTrueOrFalse();
                        })->toArray();
                    });
                });
        });

        return $fields;
    }
}
