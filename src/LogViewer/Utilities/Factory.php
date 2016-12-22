<?php namespace Orchid\LogViewer\Utilities;

use Orchid\LogViewer\Contracts\Utilities\Factory as FactoryContract;
use Orchid\LogViewer\Contracts\Utilities\Filesystem as FilesystemContract;
use Orchid\LogViewer\Contracts\Utilities\LogLevels as LogLevelsContract;
use Orchid\LogViewer\Entities\LogCollection;
use Orchid\LogViewer\Tables\StatsTable;

/**
 * Class     Factory
 *
 * @package  Orchid\LogViewer\Utilities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Factory implements FactoryContract
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The filesystem instance.
     *
     * @var \Orchid\LogViewer\Contracts\Utilities\Filesystem
     */
    protected $filesystem;

    /**
     * @var \Orchid\LogViewer\Contracts\Utilities\LogLevels
     */
    private $levels;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Create a new instance.
     *
     * @param  \Orchid\LogViewer\Contracts\Utilities\Filesystem $filesystem
     * @param  \Orchid\LogViewer\Contracts\Utilities\LogLevels $levels
     */
    public function __construct(
        FilesystemContract $filesystem,
        LogLevelsContract $levels
    )
    {
        $this->setFilesystem($filesystem);
        $this->setLevels($levels);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getter & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the filesystem instance.
     *
     * @return \Orchid\LogViewer\Contracts\Utilities\Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * Set the filesystem instance.
     *
     * @param  \Orchid\LogViewer\Contracts\Utilities\Filesystem $filesystem
     *
     * @return \Orchid\LogViewer\Utilities\Factory
     */
    public function setFilesystem(FilesystemContract $filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    /**
     * Get the log levels instance.
     *
     * @return \Orchid\LogViewer\Contracts\Utilities\LogLevels
     */
    public function getLevels()
    {
        return $this->levels;
    }

    /**
     * Set the log levels instance.
     *
     * @param  \Orchid\LogViewer\Contracts\Utilities\LogLevels $levels
     *
     * @return \Orchid\LogViewer\Utilities\Factory
     */
    public function setLevels(LogLevelsContract $levels)
    {
        $this->levels = $levels;

        return $this;
    }

    /**
     * Set the log storage path.
     *
     * @param  string $storagePath
     *
     * @return \Orchid\LogViewer\Utilities\Factory
     */
    public function setPath($storagePath)
    {
        $this->filesystem->setPath($storagePath);

        return $this;
    }

    /**
     * Get the log pattern.
     *
     * @return string
     */
    public function getPattern()
    {
        return $this->filesystem->getPattern();
    }

    /**
     * Set the log pattern.
     *
     * @param  string $date
     * @param  string $prefix
     * @param  string $extension
     *
     * @return \Orchid\LogViewer\Utilities\Factory
     */
    public function setPattern(
        $prefix = FilesystemContract::PATTERN_PREFIX,
        $date = FilesystemContract::PATTERN_DATE,
        $extension = FilesystemContract::PATTERN_EXTENSION
    )
    {
        $this->filesystem->setPattern($prefix, $date, $extension);

        return $this;
    }

    /**
     * Get all logs (alias).
     *
     * @return \Orchid\LogViewer\Entities\LogCollection
     */
    public function all()
    {
        return $this->logs();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Get all logs.
     *
     * @return \Orchid\LogViewer\Entities\LogCollection
     */
    public function logs()
    {
        return LogCollection::make()->setFilesystem($this->filesystem);
    }

    /**
     * Paginate all logs.
     *
     * @param  int $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 30)
    {
        return $this->logs()->paginate($perPage);
    }

    /**
     * Get a log by date (alias).
     *
     * @param  string $date
     *
     * @return \Orchid\LogViewer\Entities\Log
     */
    public function get($date)
    {
        return $this->log($date);
    }

    /**
     * Get a log by date.
     *
     * @param  string $date
     *
     * @return \Orchid\LogViewer\Entities\Log
     */
    public function log($date)
    {
        return $this->logs()->log($date);
    }

    /**
     * Get log entries.
     *
     * @param  string $date
     * @param  string $level
     *
     * @return \Orchid\LogViewer\Entities\LogEntryCollection
     */
    public function entries($date, $level = 'all')
    {
        return $this->logs()->entries($date, $level);
    }

    /**
     * Get logs statistics table.
     *
     * @param  string|null $locale
     *
     * @return \Orchid\LogViewer\Tables\StatsTable
     */
    public function statsTable($locale = null)
    {
        return StatsTable::make($this->stats(), $this->levels, $locale);
    }

    /**
     * Get logs statistics.
     *
     * @return array
     */
    public function stats()
    {
        return $this->logs()->stats();
    }

    /**
     * List the log files (dates).
     *
     * @return array
     */
    public function dates()
    {
        return $this->logs()->dates();
    }

    /**
     * Get logs count.
     *
     * @return int
     */
    public function count()
    {
        return $this->logs()->count();
    }

    /**
     * Get total log entries.
     *
     * @param  string $level
     *
     * @return int
     */
    public function total($level = 'all')
    {
        return $this->logs()->total($level);
    }

    /**
     * Get tree menu.
     *
     * @param  bool $trans
     *
     * @return array
     */
    public function tree($trans = false)
    {
        return $this->logs()->tree($trans);
    }

    /**
     * Get tree menu.
     *
     * @param  bool $trans
     *
     * @return array
     */
    public function menu($trans = true)
    {
        return $this->logs()->menu($trans);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Determine if the log folder is empty or not.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->logs()->isEmpty();
    }
}
