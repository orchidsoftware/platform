<?php

namespace Orchid\Alert;

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
