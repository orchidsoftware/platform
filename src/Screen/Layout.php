<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Support\Arr;
use JsonSerializable;

/**
 * Class Layout.
 */
abstract class Layout implements JsonSerializable
{
    use CanSee;

    /**
     * The Main template to display the layer
     * Represents the view() argument.
     *
     * @var string
     */
    protected $template;

    /**
     * Nested layers that should be
     * displayed along with it.
     *
     * @var Layout[]
     */
    protected $layouts = [];

    /**
     * @var array
     */
    protected $variables = [];

    /**
     * @var Repository
     */
    protected $query;

    /**
     * @return mixed
     */
    abstract public function build(Repository $repository);

    /**
     * @return mixed
     */
    protected function buildAsDeep(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return;
        }

        $build = collect($this->layouts)
            ->map(fn ($layouts) => Arr::wrap($layouts))
            ->map(fn (iterable $layouts, string $key) => $this->buildChild($layouts, $key, $repository))
            ->collapse()
            ->all();

        $variables = array_merge($this->variables, [
            'templateSlug' => $this->getSlug(),
            'manyForms'    => $build,
        ]);

        return view($this->template, $variables);
    }

    /**
     * @param array      $layouts
     * @param int|string $key
     *
     * @return array
     */
    protected function buildChild(iterable $layouts, $key, Repository $repository)
    {
        return collect($layouts)
            ->flatten()
            ->map(fn ($layout) => is_object($layout) ? $layout : resolve($layout))
            ->filter(fn () => $this->isSee())
            ->reduce(function ($build, self $layout) use ($key, $repository) {
                $build[$key][] = $layout->build($repository);

                return $build;
            }, []);
    }

    /**
     * Returns the system layer name.
     * Required to define an asynchronous layer.
     */
    public function getSlug(): string
    {
        return sha1(json_encode($this));
    }

    /**
     * @return Layout|null
     */
    public function findBySlug(string $slug)
    {
        if ($slug === $this->getSlug()) {
            return $this;
        }

        // Trying to find the right layer inside
        return collect($this->layouts)
            ->flatten()
            ->map(static function ($layout) use ($slug) {
                $layout = is_object($layout)
                    ? $layout
                    : resolve($layout);

                return $layout->findBySlug($slug);
            })
            ->filter()
            ->filter(static fn ($layout) => $slug === $layout->getSlug())
            ->first();
    }

    /**
     * @return Layout|null
     */
    public function findByType(string $type)
    {
        if (is_subclass_of($this, $type)) {
            return $this;
        }

        // Trying to find the right layer inside
        return collect($this->layouts)
            ->flatten()
            ->map(fn ($layout) => is_object($layout) ? $layout : resolve($layout))
            ->map(fn (Layout $layout) => $layout->findByType($type))
            ->filter()
            ->first();
    }

    public function jsonSerialize(): array
    {
        $props = collect(get_object_vars($this));

        return $props->except(['query'])->toArray();
    }
}
