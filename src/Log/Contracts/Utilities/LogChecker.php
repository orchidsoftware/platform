<?php

namespace Orchid\Log\Contracts\Utilities;

use Illuminate\Contracts\Config\Repository as ConfigContract;

interface LogChecker
{
    /**
     * @link http://laravel.com/docs/5.1/errors#configuration
     * @link https://github.com/Seldaek/monolog/blob/master/doc/02-handlers-formatters-processors.md#log-to-files-and-syslog
     */
    const HANDLER_DAILY = 'daily';
    const HANDLER_SINGLE = 'single';
    const HANDLER_SYSLOG = 'syslog';
    const HANDLER_ERRORLOG = 'errorlog';

    /**
     * Set the config instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     *
     * @return self
     */
    public function setConfig(ConfigContract $config);

    /**
     * Set the Filesystem instance.
     *
     * @param \Orchid\Log\Contracts\Utilities\Filesystem $filesystem
     *
     * @return self
     */
    public function setFilesystem(Filesystem $filesystem);

    /**
     * Get messages.
     *
     * @return array
     */
    public function messages();

    /**
     * Check passes ??
     *
     * @return bool
     */
    public function passes();

    /**
     * Check fails ??
     *
     * @return bool
     */
    public function fails();

    /**
     * Get the requirements.
     *
     * @return array
     */
    public function requirements();
}
