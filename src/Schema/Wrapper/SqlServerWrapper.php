<?php

namespace Orchid\Schema\Wrapper;

use Orchid\Schema\BaseSchema;
use Orchid\Schema\WrapperContract;

class SqlServerWrapper implements WrapperContract
{
    /**
     * @var BaseSchema
     */
    protected $baseSchema;

    /**
     * SqlServerWrapper constructor.
     *
     * @param BaseSchema $baseSchema
     */
    public function __construct(BaseSchema $baseSchema)
    {
        $this->baseSchema = $baseSchema;
    }

    /**
     * @return mixed
     */
    public function getSchema()
    {
        foreach ($this->getTables() as $table) {
            $columns = $this->getColumns($table);
            $this->schema[$table]['attributes'] = $columns;
            $this->schema[$table]['rowsCount'] = $this->baseSchema->getTableRowCount($table);
        }

        return $this->schema;
    }

    /**
     * @return array
     */
    public function getTables()
    {
        $databaseName = $this->baseSchema->getDatabaseName();
        $tables = $this->baseSchema->database->select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_CATALOG='$databaseName'");

        return array_map(function ($table) {
            return $table->TABLE_NAME;
        }, $tables);
    }

    /**
     * @param $tableName
     *
     * @return array
     */
    public function getColumns(string $tableName) : array
    {
        return $this->transformColumns($this->baseSchema->database->select("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$tableName'ORDER BY ORDINAL_POSITION"));
    }

    /**
     * Transform columns.
     *
     * @param $columns
     *
     * @return array
     */
    private function transformColumns(array $columns) : array
    {
        return array_map(function ($column) {
            return [
                'Field'        => $column->COLUMN_NAME,
                'Type'         => $column->DATA_TYPE,
                'Null'         => $column->IS_NULLABLE,
                'Key'          => $column->ORDINAL_POSITION,
                'Default'      => $column->COLUMN_DEFAULT,
                'Char max len' => $column->CHARACTER_MAXIMUM_LENGTH,
            ];
        }, $columns);
    }
}
