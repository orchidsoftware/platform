<?php

declare(strict_types=1);

namespace Orchid\Alert;

use Illuminate\Session\Store;
use Orchid\Support\Color;

/**
 * Class Alert.
 */
class Alert
{
    /**
     * @deprecated
     */
    public const INFO = 'info';

    /**
     * @deprecated
     */
    public const SUCCESS = 'success';

    /**
     * @deprecated
     */
    public const ERROR = 'danger';

    /**
     * @deprecated
     */
    public const WARNING = 'warning';

    /**
     * @var string
     */
    public const SESSION_MESSAGE = 'flash_notification.message';

    /**
     * @var string
     */
    public const SESSION_LEVEL = 'flash_notification.level';

    /**
     * @var Store
     */
    protected $session;

    /**
     * Create a new flash notifier instance.
     *
     * @param Store $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Flash an information message.
     *
     * @param string $message
     *
     * @return Alert
     */
    public function info(string $message): self
    {
        $this->message($message);

        return $this;
    }

    /**
     * Flash a general message.
     *
     * @param string $message
     * @param string $level
     *
     * @return Alert
     */
    public function message(string $message, string $level = null): self
    {
        $level = $level ?? (string) Color::INFO();

        $this->session->flash(static::SESSION_MESSAGE, $message);
        $this->session->flash(static::SESSION_LEVEL, $level);

        return $this;
    }

    /**
     * Flash a success message.
     *
     * @param string $message
     *
     * @return Alert
     */
    public function success(string $message): self
    {
        $this->message($message, (string) Color::SUCCESS());

        return $this;
    }

    /**
     * Flash an error message.
     *
     * @param string $message
     *
     * @return Alert
     */
    public function error(string $message): self
    {
        $this->message($message, (string)Color::ERROR());

        return $this;
    }

    /**
     * Flash a warning message.
     *
     * @param string $message
     *
     * @return Alert
     */
    public function warning(string $message): self
    {
        $this->message($message, (string) Color::WARNING());

        return $this;
    }

    /**
     * Flash a view message.
     *
     * @param string $template
     * @param string $level
     * @param array  $data
     *
     * @throws \Throwable
     *
     * @return Alert
     */
    public function view(string $template, string $level = self::INFO, array $data = []): self
    {
        $message = view($template, $data)->render();

        $this->message($message, $level);

        return $this;
    }

    /**
     * Checks if a message has been set before.
     *
     * @return bool
     */
    public function check(): bool
    {
        return $this->session->has(static::SESSION_MESSAGE);
    }
}
