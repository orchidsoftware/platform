<?php

namespace Orchid\Platform\Configuration;

use Illuminate\Support\Collection;
use Orchid\Screen\Actions\Menu;

trait ManagesMenu
{
    /**
     * The collection of menu items.
     *
     * @var Collection<Menu>
     */
    private ?Collection $menuItems;

    /**
     * @return Collection<Menu>
     */
    public function menu(): Collection
    {
        $this->menuItems = $this->menuItems ?? collect();

        return $this->menuItems;
    }

    /**
     * Register a menu element with the Dashboard.
     *
     * @param Menu $menu The menu element to add.
     *
     * @return $this
     */
    public function registerMenuElement(Menu $menu): static
    {
        if ($menu->get('sort', 0) === 0) {
            $menu->sort($this->menu->count() + 1);
        }

        $this->menu()->add($menu);

        return $this;
    }

    /**
     * Render the menu as a string for display.
     *
     * @throws \Throwable If rendering fails.
     *
     * @return string The rendered menu HTML.
     */
    public function renderMenu(): string
    {
        return $this->menu()
            ->sort(fn (Menu $current, Menu $next) => $current->get('sort', 0) <=> $next->get('sort', 0))
            ->map(fn (Menu $menu) => (string) $menu->render())
            ->implode('');
    }

    /**
     * Check if the menu is empty.
     *
     * @return bool True if the menu is empty, otherwise false.
     */
    public function isEmptyMenu(): bool
    {
        return $this->menu()->isEmpty();
    }

    /**
     * Add submenu items to a menu element identified by its slug.
     *
     * @param string $slug The slug of the menu element to update.
     * @param Menu[] $list Array of submenu items to add.
     *
     * @return $this
     */
    public function addMenuSubElements(string $slug, array $list): static
    {
        $this->menuItems = $this->menu()
            ->map(fn (Menu $menu) => $slug === $menu->get('slug')
                ? $menu->list($list)
                : $menu);

        return $this;
    }
}
