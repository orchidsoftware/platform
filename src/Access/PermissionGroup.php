<?php

declare(strict_types=1);

namespace Orchid\Access;

/**
 * A named group of permissions registered with Orchid.
 *
 * Groups describe the available permission catalog. Assigned permission
 * states are stored separately by the Permissions cast.
 */
class PermissionGroup
{
    /**
     * @param array<int, array{slug: string, description: string}> $definitions
     */
    public function __construct(
        public string $name,
        protected array $definitions = []
    ) {}

    /**
     * Create a new permission group.
     */
    public static function make(string $name): static
    {
        return new static($name);
    }

    /**
     * Add a permission definition to the group.
     */
    public function add(string $slug, string $description): static
    {
        $this->definitions[] = [
            'slug'        => $slug,
            'description' => $description,
        ];

        return $this;
    }

    /**
     * @return array<int, array{slug: string, description: string}>
     */
    public function definitions(): array
    {
        return $this->definitions;
    }
}
