<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Repository;

/**
 * Class Tabs.
 */
abstract class View extends Base
{
    /**
     * @var string
     */
    public $template;

    /**
     * View constructor.
     *
     * @param string $template
     */
    public function __construct(string $template)
    {
        $this->template = $template;
    }

    /**
     * @param Repository $repository
     *
     * @return mixed
     */
    public function build(Repository $repository)
    {
        return view($this->template, $repository->toArray());
    }
}
