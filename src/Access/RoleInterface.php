<?php

declare(strict_types=1);

namespace Orchid\Access;

interface RoleInterface
{
    /**
     * Returns all users for the role.
     *
     * @return \IteratorAggregate
     */
    public function getUsers();
}
