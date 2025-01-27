<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\View;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Columns.
 */
abstract class Columns extends Layout
{
    protected string $template = 'platform::layouts.columns';

    /**
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
