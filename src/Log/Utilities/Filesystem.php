<?php

namespace Orchid\Log\Utilities;

use Illuminate\Filesystem\Filesystem as IlluminateFilesystem;
use Orchid\Log\Contracts\Utilities\Filesystem as FilesystemContract;
use Orchid\Log\Exceptions\FilesystemException;

class Filesystem implements FilesystemContract
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * The base storage path.
     *
     * @var string
     */
    protected $storagePath;

    /**
     * The log files prefix pattern.
     *
     * @var string
     */
    protected $prefixPattern;

    /**
     * The log files date pattern.
     *
     * @var string
     */
    protected $datePattern;

    /**
     * The log files extension.
     *
     * @var string
     */
    protected $extension;

    /**
     * Filesystem constructor.
     *
     * @param \Illuminate\Filesystem\Filesystem $files
     * @param string                            $storagePath
     */
    public function __construct(IlluminateFilesystem $files, $storagePath)
    {
        $this->filesystem = $files;
        $this->setPath($storagePath);
        $this->setPattern();
    }

    /**
     * Set the log storage path.
     *
     * @param string $storagePath
     *
     * @return \Orchid\Log\Utilities\Filesystem
     */
    public function setPath($storagePath)
    {
        $this->storagePath = $storagePath;

        return $this;
    }

    /**
     * Set the log pattern.
     *
     * @param string $date
     * @param string $prefix
     * @param string $extension
     *
     * @return \Orchid\Log\Utilities\Filesystem
     */
    public function setPattern(
        $prefix = self::PATTERN_PREFIX,
        $date = self::PATTERN_DATE,
        $extension = self::PATTERN_EXTENSION
    ) {
        $this->setPrefixPattern($prefix);
        $this->setDatePattern($date);
        $this->setExtension($extension);

        return $this;
    }

    /**
     * Set the log prefix pattern.
     *
     * @param string $prefixPattern
     *
     * @return \Orchid\Log\Utilities\Filesystem
     */
    public function setPrefixPattern($prefixPattern)
    {
        $this->prefixPattern = $prefixPattern;

        return $this;
    }

    /**
     * Set the log date pattern.
     *
     * @param string $datePattern
     *
     * @return \Orchid\Log\Utilities\Filesystem
     */
    public function setDatePattern($datePattern)
    {
        $this->datePattern = $datePattern;

        return $this;
    }

    /**
     * Set the log extension.
     *
     * @param string $extension
     *
     * @return \Orchid\Log\Utilities\Filesystem
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get the files instance.
     *
     * @return \Illuminate\Filesystem\Filesystem
     */
    public function getInstance()
    {
        return $this->filesystem;
    }

    /**
     * Get all log files.
     *
     * @return array
     */
    public function all()
    {
        return $this->getFiles('*' . $this->extension);
    }

    /**
     * Get all files.
     *
     * @param string $pattern
     *
     * @return array
     */
    private function getFiles($pattern)
    {
        $files = $this->filesystem->glob(
            $this->storagePath . DIRECTORY_SEPARATOR . $pattern, GLOB_BRACE
        );

        return array_filter(array_map('realpath', $files));
    }

    /**
     * List the log files (Only dates).
     *
     * @param bool $withPaths
     *
     * @return array
     */
    public function dates($withPaths = false)
    {
        $files = array_reverse($this->logs());
        $dates = $this->extractDates($files);

        if ($withPaths) {
            $dates = array_combine($dates, $files); // [date => file]
        }

        return $dates;
    }

    /**
     * Get all valid log files.
     *
     * @return array
     */
    public function logs()
    {
        return $this->getFiles($this->getPattern());
    }

    /**
     * Get the log pattern.
     *
     * @return string
     */
    public function getPattern()
    {
        return $this->prefixPattern . $this->datePattern . $this->extension;
    }

    /**
     * Extract dates from files.
     *
     * @param array $files
     *
     * @return array
     */
    private function extractDates(array $files)
    {
        return array_map(function ($file) {
            return extract_date(basename($file));
        }, $files);
    }

    /**
     * Read the log.
     *
     * @param string $date
     *
     * @throws \Orchid\Log\Exceptions\FilesystemException
     *
     * @return string
     */
    public function read($date)
    {
        try {
            $path = $this->getLogPath($date);

            return $this->filesystem->get($path);
        } catch (\Exception $e) {
            throw new FilesystemException($e->getMessage());
        }
    }

    /**
     * Get the log file path.
     *
     * @param string $date
     *
     * @throws \Orchid\Log\Exceptions\FilesystemException
     *
     * @return string
     */
    private function getLogPath($date)
    {
        $path = $this->storagePath . DIRECTORY_SEPARATOR . $this->prefixPattern . $date . $this->extension;

        if (!$this->filesystem->exists($path)) {
            throw new FilesystemException("The log(s) could not be located at : $path");
        }

        return realpath($path);
    }

    /**
     * Delete the log.
     *
     * @param string $date
     *
     * @throws \Orchid\Log\Exceptions\FilesystemException
     *
     * @return bool
     */
    public function delete($date)
    {
        $path = $this->getLogPath($date);

        // @codeCoverageIgnoreStart
        if (!$this->filesystem->delete($path)) {
            throw new FilesystemException('There was an error deleting the log.');
        }

        // @codeCoverageIgnoreEnd

        return true;
    }

    /**
     * Get the log file path.
     *
     * @param string $date
     *
     * @return string
     */
    public function path($date)
    {
        return $this->getLogPath($date);
    }
}
