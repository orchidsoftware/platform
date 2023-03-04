<?php

declare(strict_types=1);

namespace Orchid\Platform;

class ItemPermission
{
    /**
     * @var string
     */
    public $group;

    /**
     * @var array[]
     */
    public $items = [];

    public static function group(string $group): self
    {
        $item = new self();

        $item->group = $group;

        return $item;
    }

    /**
     * @return $this
     */
    public function addPermission(string $slug, string $name)
    {
        $this->items[] = [
            'slug'        => $slug,
            'description' => $name,
        ];

        return $this;
    }
}
