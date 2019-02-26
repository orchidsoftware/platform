<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Support\Arr;
use Orchid\Screen\Repository;
use Orchid\Screen\Traits\DeepLayout;

/**
 * Class Columns.
 */
abstract class Columns extends Base
{
    /**
     * @var string
     */
    public $template = 'platform::container.layouts.columns';

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