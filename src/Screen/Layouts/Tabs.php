<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Tabs.
 */
abstract class Tabs extends Layout
{
    public $template = 'orchid::layouts.tabs';

    protected $variables = [
        'activeTab'    => null,
    ];

    /**
     * Layout constructor.
     *
     * @param array<Layout|string|array<Layout|string>> $layouts
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
        return $this->buildAsDeep($repository);
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
