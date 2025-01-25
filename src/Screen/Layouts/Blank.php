<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Blank.
 */
abstract class Blank extends Layout
{

    protected string $template = 'platform::layouts.blank';

    /**
     * Layout constructor.
     *
     * @param Layout[] $layouts
     */
    public function __construct(array $layouts = [])
    {
        $this->layouts = $layouts;
    }

    public function build(Repository $repository): \Illuminate\View\View
    {
        return $this->buildAsDeep($repository);
    }
}
