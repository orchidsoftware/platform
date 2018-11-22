<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

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
    public function canSee(): bool
    {
        return true;
    }
}
