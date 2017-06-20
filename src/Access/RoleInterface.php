<?php

namespace Orchid\Access;

interface RoleInterface
{
    /**
     * Returns the role's primary key.
     *
     * @return int
     */
    public function getRoleId() : int;

    /**
     * Returns the role's slug.
     *
     * @return string
     */
    public function getRoleSlug() : string;

    /**
     * Returns all users for the role.
     *
     * @return \IteratorAggregate
     */
    public function getUsers();
}
