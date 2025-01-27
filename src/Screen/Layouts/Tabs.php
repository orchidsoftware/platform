<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\View;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Tabs.
 */
abstract class Tabs extends Layout
{
    public string $template = 'platform::layouts.tabs';

    protected array $variables = [
        'activeTab'    => null,
    ];

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

    public function activeTab(string $name): static
    {
        $this->variables['activeTab'] = $name;

        return $this;
    }
}
