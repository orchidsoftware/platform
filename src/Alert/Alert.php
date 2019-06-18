<?php

declare(strict_types=1);

namespace Orchid\Alert;

use Illuminate\Session\Store;

/**
 * Class Alert.
 */
class Alert
{
    /**
     * Status.
     */
    public const INFO = 'info';

    /**
     * Status.
     */
    public const SUCCESS = 'success';

    /**
     * Status.
     */
    public const ERROR = 'danger';

    /**
     * Status.
     */
    public const WARNING = 'warning';

    /**
     * @var Store
     */
    private $session;

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
    public function info($message): self
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
    public function message($message, $level = self::INFO): self
    {
        $this->session->flash('flash_notification.message', $message);
        $this->session->flash('flash_notification.level', $level);

        return $this;
    }

    /**
     * Flash a success message.
     *
     * @param string $message
     *
     * @return Alert
     */
    public function success($message): self
    {
        $this->message($message, self::SUCCESS);

        return $this;
    }

    /**
     * Flash an error message.
     *
     * @param string $message
     *
     * @return Alert
     */
    public function error($message): self
    {
        $this->message($message, self::ERROR);

        return $this;
    }

    /**
     * Flash a warning message.
     *
     * @param string $message
     *
     * @return Alert
     */
    public function warning($message): self
    {
        $this->message($message, self::WARNING);

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
    public function check() : bool
    {
        return $this->session->has('flash_notification.message');
    }
}
