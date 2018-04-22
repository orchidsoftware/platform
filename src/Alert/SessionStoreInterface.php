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
     * @param $name
     * @param $data
     */
    public function flash($name, $data);
}
