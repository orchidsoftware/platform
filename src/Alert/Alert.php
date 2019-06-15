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
    public function message($message, $level = 'info'): self
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
        $this->message($message, 'success');

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
        $this->message($message, 'danger');

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
        $this->message($message, 'warning');

        return $this;
    }
}
