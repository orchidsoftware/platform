<?php

declare(strict_types=1);

namespace Orchid\Access;

use Illuminate\Support\Collection;
use Orchid\Support\Facades\Dashboard;

trait StatusAccess
{
    /**
     * Get a collection of grouped permissions with their active status.
     *
     * @return Collection<int, Collection<int, array{slug: string, description: string, active: bool}>>
     */
    public function statusOfPermissions(): Collection
    {
        $permissions = $this->permissions ?? [];

        return Dashboard::getPermission()->transform(
            fn ($group) => collect($group)
                ->sortBy('description')
                ->map(
                    fn ($item) => [
                        ...$item,
                        'active' => $this->isActive($item['slug'], $permissions),
                    ]
                )
        );
    }

    /**
     * @deprecated Use getStatusPermissions() instead.
     *
     * @return Collection<int, Collection<int, array{slug: string, description: string, active: bool}>>
     */
    public function getStatusPermission(): Collection
    {
        return $this->statusOfPermissions();
    }

    /**
     * Determine if a given permission slug is active.
     *
     * @param  string  $slug
     * @param  array<string, bool|int>  $permissions
     * @return bool
     */
    private function isActive(string $slug, array $permissions): bool
    {
        return array_key_exists($slug, $permissions) && (bool) $permissions[$slug];
    }
}
