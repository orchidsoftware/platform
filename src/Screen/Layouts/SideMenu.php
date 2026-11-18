<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Orchid\Screen\Actions\Menu;
use Orchid\Screen\Builder;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Throwable;

/**
 * Contextual vertical navigation for a related group of screens.
 */
abstract class SideMenu extends Layout
{
    /**
     * @var string
     */
    protected $template = 'orchid::layouts.sideMenu';

    /**
     * @throws Throwable
     *
     * @return Factory|View|void
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        $navigations = collect($this->navigations())
            ->filter(fn (Menu $navigation) => $navigation->isSee())
            ->values();

        if (! $this->isSee() || $navigations->isEmpty()) {
            return;
        }

        $domId = 'side-menu-'.substr($this->getSlug(), 0, 10).'-'.spl_object_id($this);

        $this->namespaceNavigations($navigations, $domId, $domId);

        $form = new Builder($navigations, $repository);

        return view($this->template, [
            'domId'       => $domId,
            'label'       => $this->label(),
            'navigations' => $form->generateForm(),
        ]);
    }

    /**
     * Get the accessible label used by the navigation landmark.
     */
    protected function label(): string
    {
        return 'Navigation';
    }

    /**
     * Keep collapse targets local to this layout instance.
     *
     * @param iterable<int, Menu> $navigations
     */
    private function namespaceNavigations(iterable $navigations, string $prefix, string $parent): void
    {
        collect($navigations)
            ->values()
            ->each(function (Menu $navigation, int $index) use ($prefix, $parent) {
                $slug = $prefix.'-'.$index;
                $children = collect($navigation->get('list', []))
                    ->filter(fn (Menu $child) => $child->isSee())
                    ->values();

                if ($navigation->get('active') === null) {
                    $navigation->active($this->activePatterns($navigation, $children));
                }

                $navigation
                    ->slug($slug)
                    ->parent($parent)
                    ->set('class', str_replace('gap-3', 'gap-2', (string) $navigation->get('class')))
                    ->addClass(['btn', 'btn-block', 'rounded-2', 'px-2', 'text-start', 'justify-content-start'])
                    ->set('disclosure', true)
                    ->set('visibleDivider', true)
                    ->set('list', $children);

                $navigation->addBeforeRender(function () use ($navigation) {
                    if ((string) active($navigation->get('active')) !== '') {
                        $navigation->addClass('fw-semibold');
                    }
                });

                if ($children->isNotEmpty()) {
                    $this->namespaceNavigations($children, $slug, $slug);
                }
            });
    }

    /**
     * Keep leaf selection exact while allowing disclosure items to represent descendants.
     *
     * @param iterable<int, Menu> $children
     *
     * @return array<int, string>
     */
    private function activePatterns(Menu $navigation, iterable $children): array
    {
        $children = collect($children);
        $urls = $children->isEmpty()
            ? collect([$navigation->get('href')])
            : $this->navigationUrls($children);

        return $urls
            ->filter()
            ->flatMap(fn (string $url) => $children->isEmpty()
                ? [$url, $url.'?*']
                : [$url, $url.'?*', $url.'/*'])
            ->unique()
            ->values()
            ->all();
    }

    /**
     * @param iterable<int, Menu> $navigations
     *
     * @return Collection<int, string>
     */
    private function navigationUrls(iterable $navigations): Collection
    {
        return collect($navigations)
            ->flatMap(fn (Menu $navigation) => collect([$navigation->get('href')])
                ->merge($this->navigationUrls($navigation->get('list', []))))
            ->filter()
            ->values();
    }

    /**
     * Get the menu elements to be displayed.
     *
     * @return Menu[]
     */
    abstract protected function navigations(): iterable;
}
