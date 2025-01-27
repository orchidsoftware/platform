<?php

declare(strict_types=1);

namespace Orchid\Alert;

use Illuminate\Session\Store;
use Orchid\Support\Color;

/**
 * Flash notifier class that shows different types of alert messages.
 */
class Alert
{
    /**
     * Session key for the message.
     */
    public const SESSION_MESSAGE = 'flash_notification.message';

    /**
     * Session key for the level.
     */
    public const SESSION_LEVEL = 'flash_notification.level';

    /**
     * Whether to run PHP's htmlspecialchars function to prevent attacks against scripts.
     */
    protected bool $sanitize = true;

    /**
     * Instantiate the flash notifier with session.
     *
     * @param \Illuminate\Session\Store $session The session store instance.
     */
    public function __construct(protected Store $session) {}

    /**
     * Flash an information message.
     *
     * @param string $message The message to flash.
     *
     * @return $this
     */
    public function info(string $message): self
    {
        $this->message($message);

        return $this;
    }

    /**
     * Flash a general message.
     *
     * @param string $message The message to flash.
     * @param Color  $color   The color of the message (default: Color::INFO).
     *
     * @return static
     */
    public function message(string $message, Color $color = Color::INFO): static
    {
        $this->session->flash(static::SESSION_MESSAGE, $this->sanitize ? e($message) : $message);
        $this->session->flash(static::SESSION_LEVEL, $color->name());

        return $this;
    }

    /**
     * Flash a success message.
     *
     * @param string $message The message to flash.
     *
     * @return static
     */
    public function success(string $message): static
    {
        $this->message($message, Color::SUCCESS);

        return $this;
    }

    /**
     * Flash an error message.
     *
     * @param string $message The message to flash.
     *
     * @return static
     */
    public function error(string $message): static
    {
        $this->message($message, Color::ERROR);

        return $this;
    }

    /**
     * Flash a warning message.
     *
     * @param string $message The message to flash.
     *
     * @return static
     */
    public function warning(string $message): static
    {
        $this->message($message, Color::WARNING);

        return $this;
    }

    /**
     * Flash a view message.
     *
     * @param string $template The name of the view to flash.
     * @param Color  $color    The color of the message (default: Color::INFO).
     * @param array  $data     The data to pass to the view.
     *
     * @throws \Throwable
     *
     * @return static
     */
    public function view(string $template, Color $color = Color::INFO, array $data = []): static
    {
        $message = view($template, $data)->render();

        $this->sanitize = false;
        $this->message($message, $color);

        return $this;
    }

    /**
     * Set the $sanitize property too false to prevent escaping data.
     *
     * @return static
     */
    public function withoutEscaping(): static
    {
        $this->sanitize = false;

        return $this;
    }

    /**
     * Check if a message has been set before.
     *
     * @return bool
     */
    public function check(): bool
    {
        return $this->session->has(static::SESSION_MESSAGE);
    }
}
