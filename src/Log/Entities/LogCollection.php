<?php

namespace Orchid\Log\Entities;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Orchid\Log\Contracts\Utilities\Filesystem as FilesystemContract;
use Orchid\Log\Exceptions\LogNotFoundException;

class LogCollection extends Collection
{
    /**
     * @var \Orchid\Log\Contracts\Utilities\Filesystem
     */
    private $filesystem;

    /**
     * LogCollection constructor.
     *
     * @param array $items
     */
    public function __construct($items = [])
    {
        $this->setFilesystem(app('arcanedev.log-viewer.filesystem'));

        parent::__construct($items);

        if (empty($items)) {
            $this->load();
        }
    }

    /**
     * Set the filesystem instance.
     *
     * @param \Orchid\Log\Contracts\Utilities\Filesystem $filesystem
     *
     * @return \Orchid\Log\Entities\LogCollection
     */
    public function setFilesystem(FilesystemContract $filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    /**
     * Load all logs.
     *
     * @return \Orchid\Log\Entities\LogCollection
     */
    private function load()
    {
        foreach ($this->filesystem->dates(true) as $date => $path) {
            $log = Log::make($date, $path, $this->filesystem->read($date));

            $this->put($date, $log);
        }

        return $this;
    }

    /**
     * Paginate logs.
     *
     * @param int $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 30)
    {
        $request = request();
        $currentPage = $request->input('page', 1);
        $paginator = new LengthAwarePaginator(
            $this->slice(($currentPage * $perPage) - $perPage, $perPage),
            $this->count(),
            $perPage,
            $currentPage
        );

        return $paginator->setPath($request->url());
    }

    /**
     * Get a log (alias).
     *
     * @see get()
     *
     * @param string $date
     *
     * @return \Orchid\Log\Entities\Log
     */
    public function log($date)
    {
        return $this->get($date);
    }

    /**
     * Get a log.
     *
     * @param string     $date
     * @param mixed|null $default
     *
     * @throws \Orchid\Log\Exceptions\LogNotFoundException
     *
     * @return \Orchid\Log\Entities\Log
     */
    public function get($date, $default = null)
    {
        if (!$this->has($date)) {
            throw new LogNotFoundException("Log not found in this date [$date]");
        }

        return parent::get($date, $default);
    }

    /**
     * Get log entries.
     *
     * @param string $date
     * @param string $level
     *
     * @return \Orchid\Log\Entities\LogEntryCollection
     */
    public function entries($date, $level = 'all')
    {
        return $this->get($date)->entries($level);
    }

    /**
     * Get logs statistics.
     *
     * @return array
     */
    public function stats()
    {
        $stats = [];

        foreach ($this->items as $date => $log) {
            /* @var \Orchid\Log\Entities\Log $log */
            $stats[$date] = $log->stats();
        }

        return $stats;
    }

    /**
     * List the log files (dates).
     *
     * @return array
     */
    public function dates()
    {
        return $this->keys()->toArray();
    }

    /**
     * Get entries total.
     *
     * @param string $level
     *
     * @return int
     */
    public function total($level = 'all')
    {
        return (int) $this->sum(function (Log $log) use ($level) {
            return $log->entries($level)->count();
        });
    }

    /**
     * Get logs tree.
     *
     * @param bool $trans
     *
     * @return array
     */
    public function tree($trans = false)
    {
        $tree = [];

        foreach ($this->items as $date => $log) {
            /* @var \Orchid\Log\Entities\Log $log */
            $tree[$date] = $log->tree($trans);
        }

        return $tree;
    }

    /**
     * Get logs menu.
     *
     * @param bool $trans
     *
     * @return array
     */
    public function menu($trans = true)
    {
        $menu = [];

        foreach ($this->items as $date => $log) {
            /* @var \Orchid\Log\Entities\Log $log */
            $menu[$date] = $log->menu($trans);
        }

        return $menu;
    }
}
