<?php

declare(strict_types=1);

namespace Orchid\Platform\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Tabuna\Breadcrumbs\Crumb;
use Tabuna\Breadcrumbs\Manager;

class Breadcrumbs extends Component
{
    /**
     * The maximum number of breadcrumbs shown before collapsing into a dropdown.
     */
    private const MAX_VISIBLE_WITHOUT_COLLAPSE = 3;

    /**
     * The number of breadcrumbs kept before the dropdown.
     */
    private const ITEMS_BEFORE_DROPDOWN = 1;

    /**
     * The number of breadcrumbs kept after the dropdown.
     */
    private const ITEMS_AFTER_DROPDOWN = 2;

    /**
     * The prepared breadcrumb items for the view.
     *
     * @var Collection<int, array{breadcrumb: Crumb, current: bool}|array{breadcrumbs: Collection<int, Crumb>}>
     */
    public Collection $items;

    /**
     * Create a new component instance.
     */
    public function __construct(Manager $manager)
    {
        $this->items = $this->resolveBreadcrumbs($manager)
            ->pipe($this->collapse(...));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('orchid::components.breadcrumbs');
    }

    /**
     * Determine if the component should be rendered.
     */
    public function shouldRender(): bool
    {
        return $this->items->isNotEmpty();
    }

    /**
     * Resolve the current breadcrumbs from the manager.
     *
     * @return Collection<int, Crumb>
     */
    private function resolveBreadcrumbs(Manager $manager): Collection
    {
        return $manager->has()
            ? $manager->current()->values()
            : collect();
    }

    /**
     * Collapse the breadcrumbs into a compact representation when necessary.
     *
     * @param Collection<int, Crumb> $breadcrumbs
     *
     * @return Collection<int, array{breadcrumb: Crumb, current: bool}|array{breadcrumbs: Collection<int, Crumb>}>
     */
    private function collapse(Collection $breadcrumbs): Collection
    {
        return $breadcrumbs->when(
            $breadcrumbs->count() <= self::MAX_VISIBLE_WITHOUT_COLLAPSE,
            fn () => $this->mapAsBreadcrumbs($breadcrumbs),
            fn () => $this->buildCollapsedItems($breadcrumbs),
        );
    }

    /**
     * Map each crumb into a breadcrumb item, marking the last one as current.
     *
     * @param Collection<int, Crumb> $breadcrumbs
     *
     * @return Collection<int, array{breadcrumb: Crumb, current: bool}>
     */
    private function mapAsBreadcrumbs(Collection $breadcrumbs): Collection
    {
        return $breadcrumbs->map(
            fn (Crumb $breadcrumb, int $index) => $this->makeBreadcrumbItem(
                $breadcrumb,
                current: $index === $breadcrumbs->count() - 1
            )
        );
    }

    /**
     * Build a collapsed list: first item, dropdown of middle items, then the last two.
     *
     * @param Collection<int, Crumb> $breadcrumbs
     *
     * @return Collection<int, array{breadcrumb: Crumb, current: bool}|array{breadcrumbs: Collection<int, Crumb>}>
     */
    private function buildCollapsedItems(Collection $breadcrumbs): Collection
    {
        return collect([
            $this->makeBreadcrumbItem($breadcrumbs->first()),
            ['breadcrumbs' => $breadcrumbs->slice(self::ITEMS_BEFORE_DROPDOWN, -self::ITEMS_AFTER_DROPDOWN)->values()],
            $this->makeBreadcrumbItem($breadcrumbs->skip(-self::ITEMS_AFTER_DROPDOWN)->first()),
            $this->makeBreadcrumbItem($breadcrumbs->last(), current: true),
        ]);
    }

    /**
     * Create a single breadcrumb item.
     *
     * @return array{breadcrumb: Crumb, current: bool}
     */
    private function makeBreadcrumbItem(Crumb $breadcrumb, bool $current = false): array
    {
        return [
            'breadcrumb' => $breadcrumb,
            'current'    => $current,
        ];
    }
}
