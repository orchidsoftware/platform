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
     * Automatically sent via PHP's htmlspecialchars function to prevent attacks
     *
     * @var bool
     */
    protected bool $sanitize = true;

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
     * @param string     $message
     * @param Color|null $level
     *
     * @return Alert
     */
    public function message(string $message, Color $level = null): self
    {
        $level = $level ?? Color::INFO();

        $this->session->flash(static::SESSION_MESSAGE, $this->sanitize ? e($message) : $message);
        $this->session->flash(static::SESSION_LEVEL, (string) $level);

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
        $this->message($message, Color::SUCCESS());

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
        $this->message($message, Color::ERROR());

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
        $this->message($message, Color::WARNING());

        return $this;
    }

    /**
     * Flash a view message.
     *
     * @param string     $template
     * @param Color|null $level
     * @param array      $data
     *
     * @throws \Throwable
     *
     * @return Alert
     */
    public function view(string $template, Color $level = null, array $data = []): self
    {
        $message = view($template, $data)->render();

        $this->sanitize = false;
        $this->message($message, $level ?? Color::INFO());

        return $this;
    }

    /**
     * If you don't want your data to be escaped, use this method.
     *
     * @return $this
     */
    public function withoutEscaping(): self
    {
        $this->sanitize = false;

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
