<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Wrapper.
 */
abstract class Wrapper extends Layout
{
    /**
     * Wrapper constructor.
     *
     * @param view-string                               $template
     * @param array<Layout|string|array<Layout|string>> $layouts
     */
    public function __construct(string $template, array $layouts = [])
    {
        $this->template = $template;
        $this->layouts = $layouts;
    }

    /**
     * @return View|void
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return;
        }

        $build = collect($this->layouts)
            ->map(function ($layout, $key) use ($repository) {
                $items = $this->buildChild(Arr::wrap($layout), $key, $repository);

                return is_array($layout) ? ($items[$key] ?? []) : ($items[$key][0] ?? null);
            })
            ->merge($repository->all())
            ->all();

        return view($this->template, $build);
    }
}
