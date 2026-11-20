<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Support\Arr;
use Illuminate\View\View;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Traversable;

/**
 * Class Blank.
 */
abstract class Blank extends Layout
{
    protected $template = 'orchid::layouts.blank';

    /**
     * Layout constructor.
     *
     * @param array<Layout|string|iterable<Layout|string>> $layouts
     */
    public function __construct(array $layouts = [])
    {
        $this->layouts = [];

        foreach ($layouts as $key => $layout) {
            $this->layouts[$key] = $layout instanceof Traversable && ! $layout instanceof Layout
                ? Arr::flatten($layout)
                : $layout;
        }
    }

    /**
     * @return View|mixed
     */
    public function build(Repository $repository)
    {
        return $this->buildAsDeep($repository);
    }
}
