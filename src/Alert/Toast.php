<?php

declare(strict_types=1);

namespace Orchid\Alert;

use Illuminate\Session\Store;

/**
 * Class Toast.
 */
class Toast extends Alert
{
    /**
     * @var string
     */
    public const SESSION_MESSAGE = 'toast_notification.message';

    /**
     * @var string
     */
    public const SESSION_LEVEL = 'toast_notification.level';

    /**
     * @var string
     */
    public const SESSION_AUTO_HIDE = 'toast_notification.auto_hide';

    /**
     * @var string
     */
    public const SESSION_DELAY = 'toast_notification.delay';

    /**
     * Create a new flash notifier instance.
     *
     * @param Store $session
     */
    public function __construct(Store $session)
    {
        parent::__construct($session);

        $this->autoHide()->delay();
    }

    /**
     * @param bool $autoHide
     *
     * @return $this
     */
    public function autoHide(bool $autoHide = true): self
    {
        $this->session->flash(static::SESSION_AUTO_HIDE, var_export($autoHide, true));

        return $this;
    }

    /**
     * @param int $delay
     *
     * @return $this
     */
    public function delay(int $delay = 5000): self
    {
        $this->session->flash(static::SESSION_DELAY, $delay);

        return $this;
    }
}
