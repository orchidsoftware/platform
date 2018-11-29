<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Repository;

/**
 * Class Base.
 */
abstract class Base
{
    /**
     * @param $query
     *
     * @return bool
     */
    public function canSee(Repository $query): bool
    {
        return true;
    }
}
