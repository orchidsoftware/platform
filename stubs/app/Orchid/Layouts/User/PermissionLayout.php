<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Illuminate\Support\Collection;
use Orchid\Platform\Models\User;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Rows;
use Throwable;

/**
 * @phpstan-type Permission array{slug: string, description: string, active: bool}
 */
class PermissionLayout extends Rows
{
    /**
     * Currently inspected user.
     *
     * @var User|null
     */
    private ?User $user;

    /**
     * The screen's layout elements.
     *
     * @throws Throwable
     *
     * @return Group[]
     */
    public function fields(): array
    {
        $this->user = $this->query->get('user');

        return $this->generatedPermissionFields(
            $this->query->getContent('permission')
        );
    }

    /**
     * Transform raw grouped permissions into Orchid fields.
     *
     * @param Collection<string, Collection<int, Permission>> $permissionsRaw
     *
     * @return Group[]
     */
    private function generatedPermissionFields(Collection $permissionsRaw): array
    {
        return $permissionsRaw
            ->map(fn (Collection $permissions, $title) => $this->makeCheckBoxGroup($permissions, $title))
            ->flatten()
            ->toArray();
    }

    /**
     * Build a grouped set of checkbox fields for a permission category.
     *
     * @param Collection<int, Permission> $permissions
     * @param string                      $title
     *
     * @return Collection<int, Group>
     */
    private function makeCheckBoxGroup(Collection $permissions, string $title): Collection
    {
        return $permissions
            ->map(fn (array $permission) => $this->makeCheckBox($permission))
            ->flatten()
            ->map(fn (CheckBox $checkbox, $key) => $key === 0
                ? $checkbox->title($title)
                : $checkbox)
            ->chunk(4)
            ->map(fn (Collection $checkboxes) => Group::make($checkboxes->toArray())
                ->alignEnd()
                ->autoWidth());
    }

    /**
     * Create a single checkbox for a permission.
     *
     * @param Permission $permission
     *
     * @return CheckBox
     */
    private function makeCheckBox(array $permission): CheckBox
    {
        return CheckBox::make('permissions.'.base64_encode($permission['slug']))
            ->placeholder($permission['description'])
            ->value($permission['active'])
            ->sendTrueOrFalse()
            ->indeterminate($this->getIndeterminateStatus(
                $permission['slug'],
                $permission['active']
            ));
    }

    /**
     * Determine if checkbox should be indeterminate (user has permission transitively).
     *
     * @param string     $permission Permission slug
     * @param bool|mixed $value      Role's permission active flag
     *
     * @return bool
     */
    private function getIndeterminateStatus(string $permission, $value): bool
    {
        return optional($this->user)->hasAccess($permission) === true && $value === false;
    }
}
