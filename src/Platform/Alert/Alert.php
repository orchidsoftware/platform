<?php

declare(strict_types=1);

namespace Orchid\Platform\Alert;

class Alert
{
    /**
     * @var SessionStoreInterface
     */
    private $session;

    /**
     * Create a new flash notifier instance.
     *
     * @param SessionStoreInterface $session
     */
    public function __construct(SessionStoreInterface $session)
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
    public function info($message)
    {
        $this->message($message, 'info');

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
    public function message($message, $level = 'info')
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
    public function success($message)
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
    public function error($message)
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
    public function warning($message)
    {
        $this->message($message, 'warning');

        return $this;
    }
}
