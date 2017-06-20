<?php

namespace Orchid\Schema;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

abstract class BaseSchema
{
    /**
     * Database instance.
     *
     * @var
     */
    public $database;

    /**
     * Connection name.
     *
     * @var
     */
    public $connection;

    /**
     * @var array
     */
    protected $schema = [];

    /**
     * BaseSchema constructor.
     */
    public function __construct()
    {
        $this->connection = DB::connection()->getName();
        $this->setConnection($this->connection);
    }

    /**
     * Set connection.
     *
     * @param $connection
     *
     * @return BaseSchema
     */
    public function setConnection(string $connection) : BaseSchema
    {
        $this->connection = $connection;
        $this->database = DB::connection($this->connection);

        return $this;
    }

    /**
     * Fetch database name.
     *
     * @return mixed
     */
    public function getDatabaseName() : string
    {
        return $this->database->getDatabaseName();
    }

    /**
     * Get table total row count.
     *
     * @param string $table
     *
     * @return int
     */
    public function getTableRowCount(string $table) : int
    {
        return $this->database->table($table)->count();
    }

    /**
     * Perform raw sql query.
     *
     * @param string $query
     *
     * @return mixed
     */
    public function rawQuery(string $query)
    {
        return $this->database->select(DB::raw($query));
    }

    /**
     * Fetch data form table using pagination.
     *
     * @param string      $tableName
     * @param int         $page
     * @param int         $limit
     * @param string|null $orderAttribute
     * @param string      $order
     *
     * @return mixed
     */
    public function getPaginatedData(
        string $tableName,
        int $page = 1,
        int $limit = 15,
        string $orderAttribute = null,
        string $order = 'DESC'
    ) {
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        $data = $this->database->table($tableName);
        if (null === $orderAttribute) {
            return $data->paginate($limit);
        }

        return $data->orderBy($orderAttribute, $order)->paginate($limit);
    }
}
