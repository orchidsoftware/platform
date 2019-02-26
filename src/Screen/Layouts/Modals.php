<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Repository;

/**
 * Class Modals.
 */
abstract class Modals extends Base
{
    /**
     * @var string
     */
    public $template = 'platform::container.layouts.modals';

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