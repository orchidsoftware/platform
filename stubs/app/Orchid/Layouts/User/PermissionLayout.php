<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Illuminate\Support\Collection;
use Orchid\Platform\Models\User;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Rows;
use Throwable;

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
     * @return Field[]
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
     * @param Collection $permissionsRaw Map<title, Collection<array>>
     *
     * @return Field[]
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
     * @param Collection $permissions Collection<array{slug: string, description: string, active: bool}>
     * @param string     $title
     *
     * @return Collection Collection<Group>
     */
    private function makeCheckBoxGroup(Collection $permissions, string $title): Collection
    {
        return $permissions
            ->map(fn (array $chunks) => $this->makeCheckBox(collect($chunks)))
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
     * @param Collection $chunks Collection{slug: string, description: string, active: bool}
     *
     * @return CheckBox
     */
    private function makeCheckBox(Collection $chunks): CheckBox
    {
        return CheckBox::make('permissions.'.base64_encode($chunks->get('slug')))
            ->placeholder($chunks->get('description'))
            ->value($chunks->get('active'))
            ->sendTrueOrFalse()
            ->indeterminate($this->getIndeterminateStatus(
                $chunks->get('slug'),
                $chunks->get('active')
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
