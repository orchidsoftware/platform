<?php

namespace Orchid\Log\Utilities;

use Illuminate\Contracts\Config\Repository as ConfigContract;
use Orchid\Log\Contracts\Utilities\Filesystem as FilesystemContract;
use Orchid\Log\Contracts\Utilities\LogChecker as LogCheckerContract;

class LogChecker implements LogCheckerContract
{
    /**
     * Log handler mode.
     *
     * @var string
     */
    protected $handler = '';

    /**
     * The config repository instance.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    private $config;

    /**
     * The filesystem instance.
     *
     * @var \Orchid\Log\Contracts\Utilities\Filesystem
     */
    private $filesystem;

    /**
     * The check status.
     *
     * @var bool
     */
    private $status = true;

    /**
     * The check messages.
     *
     * @var array
     */
    private $messages;

    /**
     * Log files statuses.
     *
     * @var array
     */
    //private $files;

    /**
     * LogChecker constructor.
     *
     * @param \Illuminate\Contracts\Config\Repository    $config
     * @param \Orchid\Log\Contracts\Utilities\Filesystem $filesystem
     */
    public function __construct(ConfigContract $config, FilesystemContract $filesystem)
    {
        $this->files = [];
        $this->setConfig($config);
        $this->setFilesystem($filesystem);
        $this->refresh();
    }

    /**
     * Set the config instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     *
     * @return \Orchid\Log\Utilities\LogChecker
     */
    public function setConfig(ConfigContract $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Set the Filesystem instance.
     *
     * @param \Orchid\Log\Contracts\Utilities\Filesystem $filesystem
     *
     * @return \Orchid\Log\Utilities\LogChecker
     */
    public function setFilesystem(FilesystemContract $filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    /**
     * Refresh the checks.
     *
     * @return \Orchid\Log\Utilities\LogChecker
     */
    private function refresh()
    {
        $this->setHandler($this->config->get('app.log', 'single'));

        $this->messages = [
            'handler' => '',
            'files'   => [],
        ];
        $this->files = [];

        $this->checkHandler();
        $this->checkLogFiles();

        return $this;
    }

    /**
     * Set the log handler mode.
     *
     * @param string $handler
     *
     * @return \Orchid\Log\Utilities\LogChecker
     */
    protected function setHandler($handler)
    {
        $this->handler = strtolower($handler);

        return $this;
    }

    /**
     * Check the handler mode.
     */
    private function checkHandler()
    {
        if ($this->isDaily()) {
            return;
        }

        $this->messages['handler'] = 'You should set the log handler to `daily` mode.';
    }

    /**
     * Is a daily handler mode ?
     *
     * @return bool
     */
    protected function isDaily()
    {
        return $this->isSameHandler(self::HANDLER_DAILY);
    }

    /**
     * Is the handler is the same as the application log handler.
     *
     * @param string $handler
     *
     * @return bool
     */
    private function isSameHandler($handler)
    {
        return $this->handler === $handler;
    }

    /**
     * Check all log files.
     */
    private function checkLogFiles()
    {
        foreach ($this->filesystem->all() as $path) {
            $this->checkLogFile($path);
        }
    }

    /**
     * Check a log file.
     *
     * @param string $path
     */
    private function checkLogFile($path)
    {
        $status = true;
        $file = basename($path);
        $message = "The log file [$file] is valid.";

        if ($this->isSingleLogFile($file)) {
            $this->status = $status = false;
            $this->messages['files'][$file] = $message =
                "You have a single log file in your application, you should split the [$file] into seperate log files.";
        } elseif ($this->isInvalidLogDate($file)) {
            $this->status = $status = false;
            $this->messages['files'][$file] = $message =
                "The log file [$file] has an invalid date, the format must be like laravel-YYYY-MM-DD.log.";
        }

        $this->files[$file] = compact('filename', 'status', 'message', 'path');
    }

    /**
     * Check if it's not a single log file.
     *
     * @param string $file
     *
     * @return bool
     */
    private function isSingleLogFile($file)
    {
        return $file === 'laravel.log';
    }

    /**
     * Check the date of the log file.
     *
     * @param string $file
     *
     * @return bool
     */
    private function isInvalidLogDate($file)
    {
        $pattern = '/laravel-(\d){4}-(\d){2}-(\d){2}.log/';

        if ((bool) preg_match($pattern, $file, $matches) === false) {
            return true;
        }

        return false;
    }

    /**
     * Get messages.
     *
     * @return array
     */
    public function messages()
    {
        $this->refresh();

        return $this->messages;
    }

    /**
     * Check if the checker fails.
     *
     * @return bool
     */
    public function fails()
    {
        return !$this->passes();
    }

    /**
     * Check if the checker passes.
     *
     * @return bool
     */
    public function passes()
    {
        $this->refresh();

        return $this->status;
    }

    /**
     * Get the requirements.
     *
     * @return array
     */
    public function requirements()
    {
        $this->refresh();

        return $this->isDaily() ? [
            'status'  => 'success',
            'header'  => 'Application requirements fulfilled.',
            'message' => 'Are you ready to rock ?',
        ] : [
            'status'  => 'failed',
            'header'  => 'Application requirements failed.',
            'message' => $this->messages['handler'],
        ];
    }
}
