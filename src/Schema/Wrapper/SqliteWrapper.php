<?php namespace Orchid\Schema\Wrapper;


use Orchid\Schema\BaseSchema;
use Orchid\Schema\WrapperContract;

/**
 * Class SqliteWrapper
 * @package Orchid\Schema\Wrapper
 */
class SqliteWrapper implements WrapperContract
{
    /**
     * @var BaseSchema
     */
    protected $baseSchema;

    /**
     * SqliteWrapper constructor.
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
        $tables = $this->baseSchema->database->select("SELECT name FROM sqlite_master WHERE type='table'");
        return array_map(function ($table) {
            return $table->name;
        }, $tables);
    }

    /**
     * @param $tableName
     * @return array
     */
    public function getColumns($tableName)
    {
        $columns = $this->baseSchema->database->select(\DB::raw("pragma table_info($tableName)"));
        return $this->transformColumns($columns);
    }

    /**
     * Transform columns
     * @param $columns
     * @return array
     */
    private function transformColumns($columns)
    {
        return array_map(function ($column) {
            return [
                'CID' => $column->cid,
                'Field' => $column->name,
                'Type' => $column->type,
                'Null' => $column->notnull,
                'Key' => $column->pk,
                'Default' => $column->dflt_value,
            ];
        }, $columns);
    }
}