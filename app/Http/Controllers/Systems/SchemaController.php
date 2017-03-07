<?php

namespace Orchid\Http\Controllers\Systems;

use Orchid\Http\Controllers\Controller;
use Orchid\Schema\Helpers;
use Orchid\Schema\Schema;

class SchemaController extends Controller
{
    use Helpers;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var int
     */
    private $page = 1;

    /**
     * @var int
     */
    private $limit = 15;

    /**
     * SchemaController constructor.
     *
     * @param Schema $schema
     */
    public function __construct(Schema $schema)
    {
        $this->checkPermission('dashboard.systems.schema');
        $this->page = request()->get('page', 1);
        $this->schema = $schema;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $tables = $this->schema->databaseWrapper->getSchema();

        return view('dashboard::container.systems.schema.schema', [
            'tables' => $tables,
        ]);
    }

    /**
     * @param $table
     *
     * @return bool
     */
    public function show($table)
    {
        $columns = $this->schema->databaseWrapper->getColumns($table);

        /*
         * Sort Primary Auto_increment or Primary Key
         */
        $attributeName = null;
        foreach ($columns as $column) {
            if (array_key_exists('Extra', $columns) && $columns['Extra'] == 'auto_increment') {
                $attributeName = $column['Field'];
            } elseif (array_key_exists('Key', $columns) && !empty($columns['Key']) && is_null($attributeName)) {
                $attributeName = $column['Field'];
            }
        }

        $rows = $this->schema->getPaginatedData($table, $this->page, $this->limit, $attributeName);

        return view('dashboard::container.systems.schema.show', [
            'columns' => $columns,
            'rows'    => $rows,
            'table'   => $table,
        ]);
    }
}
