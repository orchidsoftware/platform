<?php

declare(strict_types=1);

namespace Orchid\Alert;

/**
 * Interface SessionStoreInterface.
 */
interface SessionStoreInterface
{
    /**
     * Flash a message to the session.
     *
     * @param string $name
     * @param mixed $data
     */
    public function flash(string $name, $data);
}
