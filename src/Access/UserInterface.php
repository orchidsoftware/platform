<?php

declare(strict_types=1);

namespace Orchid\Access;

use IteratorAggregate;

/**
 * @deprecated This interface is deprecated and should not be used anymore.
 */
interface UserInterface
{
    /**
     * Returns all roles for the user.
     *
     * @return IteratorAggregate
     */
    public function getRoles();
}
