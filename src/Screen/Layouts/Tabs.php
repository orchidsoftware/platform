<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\View\View;
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

    /**
     * @param Repository $repository
     * @return View|null
     */
    public function build(Repository $repository): ?View
    {
        return $this->buildAsDeep($repository);
    }

    /**
     * @param string $name
     * @return $this
     */
    public function activeTab(string $name): self
    {
        $this->variables['activeTab'] = $name;

        return $this;
    }
}
