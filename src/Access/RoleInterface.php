<?php

declare(strict_types=1);

namespace Orchid\Access;

use IteratorAggregate;

interface RoleInterface
{
    /**
     * Return all users belonging to the role.
     *
     * @return IteratorAggregate
     */
    public function getUsers();

    /**
     * Returns the ID of the role.
     *
     * @return mixed
     */
    public function getRoleId();

    /**
     * Returns the slug of the role.
     *
     * @return string
     */
    public function getRoleSlug(): string;
}
