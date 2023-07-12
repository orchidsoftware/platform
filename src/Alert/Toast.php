<?php

declare(strict_types=1);

namespace Orchid\Alert;

use Illuminate\Session\Store;

/**
 * Class Toast
 */
class Toast extends Alert
{
    /**
     * @var string The session key for a message.
     */
    public const SESSION_MESSAGE = 'toast_notification.message';

    /**
     * @var string The session key for level.
     */
    public const SESSION_LEVEL = 'toast_notification.level';

    /**
     * @var string The session key for auto hide.
     */
    public const SESSION_AUTO_HIDE = 'toast_notification.auto_hide';

    /**
     * @var string The session key for delay.
     */
    public const SESSION_DELAY = 'toast_notification.delay';

    /**
     * Create a new flash notifier instance.
     */
    public function __construct(Store $session)
    {
        parent::__construct($session);

        $this->autoHide()->delay();
    }

    /**
     * Set the auto hide option for the toast notification.
     *
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
     * Disable the auto hide option for the toast notification.
     *
     * @param bool $disable
     *
     * @return $this
     */
    public function disableAutoHide(bool $disable = true): self
    {
        return $this->autoHide(! $disable);
    }

    /**
     * Set the delay option for the toast notification.
     *
     * @param int $delay The delay in seconds
     *
     * @return $this
     */
    public function delay(int $delay = 5000): self
    {
        $this->session->flash(static::SESSION_DELAY, $delay);

        return $this;
    }
}
