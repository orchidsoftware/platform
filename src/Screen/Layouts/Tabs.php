<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Repository;

/**
 * Class Tabs.
 */
abstract class Tabs extends Base
{
    /**
     * @var string
     */
    public $template = 'platform::layouts.tabs';

    /**
     * @param Repository $repository
     *
     * @return mixed
     */
    public function build(Repository $repository)
    {
        return $this->buildAsDeep($repository);
    }
}
