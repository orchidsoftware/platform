<?php

declare(strict_types=1);

namespace Orchid\Platform\Alert;

/**
 * Interface SessionStoreInterface.
 *
 * @category PHP
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
