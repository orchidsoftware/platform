<?php

declare(strict_types=1);

namespace Orchid\Platform\Listeners;

use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;
use Illuminate\Auth\Events\Login;

class LockUserForLogin
{
    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * @var \Illuminate\Cookie\CookieJar
     */
    private $cookie;

    /**
     * LogSuccessfulLogin constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request, CookieJar $cookieJar)
    {
        $this->request = $request;
        $this->cookie = $cookieJar;
    }

    /**
     * Handle the event.
     *
     * @param Login $event
     *
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $this->cookie->forever('lockUser', $event->user->id);

        $this->cookie->queue($user);
    }
}
