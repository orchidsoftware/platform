<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Illuminate\View\View;

/**
 * Class Columns.
 */
abstract class Columns extends Layout
{

    protected string $template = 'platform::layouts.columns';

    /**
     * Layout constructor.
     *
     * @param Layout[] $layouts
     */
    public function __construct(array $layouts = [])
    {
        $this->layouts = $layouts;
    }

    public function build(Repository $repository): ?View
    {
        return $this->buildAsDeep($repository);
    }
}
