<?php

namespace Orchid\Schema\Wrapper;

use Orchid\Schema\BaseSchema;
use Orchid\Schema\WrapperContract;

/**
 * Class PostgresWrapper.
 */
class PostgresWrapper implements WrapperContract
{
    /**
     * @var BaseSchema
     */
    protected $baseSchema;

    /**
     * PostgresWrapper constructor.
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
        $tables = $this->baseSchema->database->select("SELECT table_name FROM information_schema.tables WHERE table_schema='public'");

        return array_map(function ($table) {
            return $table->table_name;
        }, $tables);
    }

    /**
     * @param $tableName
     *
     * @return array
     */
    public function getColumns($tableName)
    {
        return $this->transformColumns($this->baseSchema->database->select("SELECT ordinal_position, column_name, data_type, is_nullable, column_default FROM information_schema.columns WHERE table_name ='$tableName'"));
    }

    /**
     * Transform columns.
     *
     * @param $columns
     *
     * @return array
     */
    private function transformColumns($columns)
    {
        return array_map(function ($column) {
            return [
                'Field'   => $column->column_name,
                'Type'    => $column->data_type,
                'Null'    => $column->is_nullable,
                'Key'     => $column->ordinal_position,
                'Default' => $column->column_default,
//                'Extra' => $column->Extra
            ];
        }, $columns);
    }
}
