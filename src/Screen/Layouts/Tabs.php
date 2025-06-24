<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Support\Arr;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Menu;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Tabs.
 */
abstract class Tabs extends Layout
{
    /**
     * @var string
     */
    public $template = 'platform::layouts.tabs';

    /**
     * @var array
     */
    protected $variables = [
        'activeTab'    => null,
    ];

    /**
     * Layout constructor.
     *
     * @param Layout[]|Link[]|Menu[] $layouts
     */
    public function __construct(array $layouts = [])
    {
        $this->layouts = $layouts;
    }

    /**
     * @return mixed
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return;
        }

        $layouts = collect($this->layouts);
        $build = [];
        $linkItems = [];

        foreach ($layouts as $key => $layout) {
            if ($layout instanceof Link) {
                $linkItems[$key] = true;
                $build[$key][] = $layout->build($repository);
            } else {
                $wrappedLayouts = Arr::wrap($layout);
                $childLayouts = collect($wrappedLayouts)
                    ->flatten()
                    ->map(fn ($item) => is_object($item) ? $item : resolve($item))
                    ->filter(fn () => $this->isSee())
                    ->reduce(function ($carry, $item) use ($key, $repository) {
                        $carry[$key][] = $item->build($repository);
                        return $carry;
                    }, []);

                if (!empty($childLayouts)) {
                    $build = array_merge_recursive($build, $childLayouts);
                }
            }
        }

        $variables = array_merge($this->variables, [
            'templateSlug' => $this->getSlug(),
            'manyForms'    => $build,
            'menuItems'    => $linkItems,
        ]);

        return view($this->template, $variables);
    }

    /**
     * @return $this
     */
    public function activeTab(string $name)
    {
        $this->variables['activeTab'] = $name;

        return $this;
    }
}
