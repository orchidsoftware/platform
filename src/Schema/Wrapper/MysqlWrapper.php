<?php

namespace Orchid\Schema\Wrapper;

use Orchid\Schema\BaseSchema;
use Orchid\Schema\Helpers;
use Orchid\Schema\WrapperContract;

class MysqlWrapper implements WrapperContract
{
    use Helpers;

    /**
     * @var BaseSchema
     */
    protected $baseSchema;

    /**
     * MysqlWrapper constructor.
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
    public function getSchema() : array
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
    public function getTables() : array
    {
        $tables = $this->baseSchema->database->select('SHOW TABLES');
        $attribute = 'Tables_in_' . $this->baseSchema->getDatabaseName();

        return array_map(function ($table) use ($attribute) {
            return $table->$attribute;
        }, $tables);
    }

    /**
     * @param string $tableName
     *
     * @return array
     */
    public function getColumns(string $tableName) : array
    {
        return $this->transformColumns($this->baseSchema->database->select('SHOW COLUMNS FROM ' . $tableName));
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
            return get_object_vars($column);
        }, $columns);
    }
}
