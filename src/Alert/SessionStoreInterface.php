<?php

declare(strict_types=1);

namespace Orchid\Alert;

/**
 * Interface SessionStoreInterface
 * @package Orchid\Alert
 */
interface SessionStoreInterface
{
    /**
     * Flash a message to the session.
     *
     * @param $name
     * @param $data
     */
    public function flash($name, $data);
}
