<?php

declare(strict_types=1);

namespace Orchid\Access;

use IteratorAggregate;

interface RoleInterface
{
    /**
     * Returns all users for the role.
     *
     * @return IteratorAggregate
     */
    public function getUsers();

    /**
     * @return int
     */
    public function getRoleId();

    /**
     * @return string
     */
    public function getRoleSlug(): string;
}
