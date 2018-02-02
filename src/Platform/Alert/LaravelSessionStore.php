<?php

declare(strict_types=1);

namespace Orchid\Platform\Alert;

use Illuminate\Session\Store;

/**
 * Class LaravelSessionStore.
 *
 * @category PHP
 */
class LaravelSessionStore implements SessionStoreInterface
{
    /**
     * @var Store
     */
    private $session;

    /**
     * LaravelSessionStore constructor.
     *
     * @param Store $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Flash some data into the session.
     *
     * @param $name
     * @param $data
     */
    public function flash($name, $data)
    {
        $this->session->flash($name, $data);
    }
}
