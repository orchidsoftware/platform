<?php

namespace Orchid\Alert;

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
    public function info(string $message) : Alert
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
    public function message(string $message, string $level = 'info') : Alert
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
    public function success(string $message) : Alert
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
    public function error(string $message) : Alert
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
    public function warning(string $message) : Alert
    {
        $this->message($message, 'warning');

        return $this;
    }
}
