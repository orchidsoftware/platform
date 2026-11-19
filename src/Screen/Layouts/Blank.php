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
    /**
     * @var string
     */
    protected $template = 'orchid::layouts.blank';

    /**
     * Layout constructor.
     *
     * @param array<Layout|string|iterable<Layout|string>> $layouts
     */
    public function __construct(array $layouts = [])
    {
        foreach ($layouts as $key => $layout) {
            if ($layout instanceof Traversable && ! $layout instanceof Layout) {
                $layouts[$key] = Arr::flatten($layout);
            }
        }

        $this->layouts = $layouts;
    }

    /**
     * @return View|mixed
     */
    public function build(Repository $repository)
    {
        return $this->buildAsDeep($repository);
    }
}
