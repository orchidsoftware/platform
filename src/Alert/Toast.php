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
     * @return static
     */
    public function autoHide(bool $autoHide = true): static
    {
        $this->session->flash(static::SESSION_AUTO_HIDE, var_export($autoHide, true));

        return $this;
    }

    /**
     * @alias persistent() method
     *
     * Disable the auto hide option for the toast notification.
     *
     * @param bool $disable
     *
     * @return static
     */
    public function disableAutoHide(bool $disable = true): static
    {
        return $this->persistent($disable);
    }

    /**
     * Make the toast notification persistent.
     *
     * Disables auto-hide, keeping the notification visible until manually dismissed.
     *
     * @param bool $persistent Whether the toast should remain visible indefinitely.
     *
     * @return static
     */
    public function persistent(bool $persistent = true): static
    {
        return $this->autoHide(! $persistent);
    }

    /**
     * Set the delay option for the toast notification.
     *
     * @param int $delay The delay in milliseconds before hiding the toast.
     *
     * @return static
     */
    public function delay(int $delay = 5000): static
    {
        $this->session->flash(static::SESSION_DELAY, $delay);

        return $this;
    }

    /**
     * Set the toast notification delay in seconds.
     *
     * Converts seconds to milliseconds and applies the delay.
     *
     * @param int $seconds Delay duration in seconds.
     *
     * @return static
     */
    public function seconds(int $seconds): static
    {
        return $this->delay($seconds * 1000);
    }
}
