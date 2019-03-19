<?php

declare(strict_types=1);

namespace Orchid\Alert;

use Illuminate\Session\Store;

/**
 * Class LaravelSessionStore.
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
     * @param string $name
     * @param mixed  $data
     */
    public function flash(string $name, $data)
    {
        $this->session->flash($name, $data);
    }
}
