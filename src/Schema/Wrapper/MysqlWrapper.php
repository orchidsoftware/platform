<?php

namespace Orchid\Schema\Wrapper;

use Orchid\Schema\Helpers;
use Orchid\Schema\BaseSchema;
use Orchid\Schema\WrapperContract;

/**
 * Class MysqlWrapper.
 */
class MysqlWrapper implements WrapperContract
{
    use Helpers;

    /**
     * @var BaseSchema
     */
    protected $baseSchema;

    /**
     * MysqlWrapper constructor.
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
        $tables = $this->baseSchema->database->select('SHOW TABLES');
        $attribute = 'Tables_in_'.$this->baseSchema->getDatabaseName();

        return array_map(function ($table) use ($attribute) {
            return $table->$attribute;
        }, $tables);
    }

    /**
     * @param $tableName
     * @return array
     */
    public function getColumns($tableName)
    {
        return $this->transformColumns($this->baseSchema->database->select('SHOW COLUMNS FROM '.$tableName));
    }

    /**
     * Transform columns.
     * @param $columns
     * @return array
     */
    private function transformColumns($columns)
    {
        return array_map(function ($column) {
            return [
                'Field' => $column->Field,
                'Type' => $column->Type,
                'Null' => $column->null,
                'Key' => $column->Key,
                'Default' => $column->Default,
                'Extra' => $column->Extra,
            ];
        }, $columns);
    }

    /**
     * Generate mysql performance information.
     * @param int $sleep
     * @return array
     */
    public function showDatabaseStatus($sleep = 2)
    {
        $uptimeStart = microtime(true);
        // start queries
        $startQueries = $this->baseSchema->rawQuery('show global status');
        $startSelect = $this->getValueIfExist($startQueries, 'Com_select');
        $startUpdate = $this->getValueIfExist($startQueries, 'Com_update');
        $startDelete = $this->getValueIfExist($startQueries, 'Com_delete');
        $startInsert = $this->getValueIfExist($startQueries, 'Com_insert');
        $startByteSent = $this->getValueIfExist($startQueries, 'Bytes_sent');
        $startByteReceived = $this->getValueIfExist($startQueries, 'Bytes_received');
        $startConnections = $this->getValueIfExist($startQueries, 'Connections');
        $startAbortedClients = $this->getValueIfExist($startQueries, 'Aborted_clients');
        $startAbortedConnections = $this->getValueIfExist($startQueries, 'Aborted_connects');

        $startCreateDb = $this->getValueIfExist($startQueries, 'Com_create_db');
        $startCreateEvent = $this->getValueIfExist($startQueries, 'Com_create_event');
        $startCreateFunc = $this->getValueIfExist($startQueries, 'Com_create_function');
        $startCreateProcedure = $this->getValueIfExist($startQueries, 'Com_create_procedure');
        $startCreateServer = $this->getValueIfExist($startQueries, 'Com_create_server');
        $startCreateTable = $this->getValueIfExist($startQueries, 'Com_create_table');
        $startCreateTrigger = $this->getValueIfExist($startQueries, 'Com_create_trigger');
        $startCreateUDF = $this->getValueIfExist($startQueries, 'Com_create_udf');
        $startCreateUser = $this->getValueIfExist($startQueries, 'Com_create_user');
        $startCreateView = $this->getValueIfExist($startQueries, 'Com_create_view');

        $startAlterDb = $this->getValueIfExist($startQueries, 'Com_alter_db');
        $startAlterDbUpgrade = $this->getValueIfExist($startQueries, 'Com_alter_db_upgrade');
        $startAlterEvent = $this->getValueIfExist($startQueries, 'Com_alter_event');
        $startAlterFunc = $this->getValueIfExist($startQueries, 'Com_alter_function');
        $startAlterProcedure = $this->getValueIfExist($startQueries, 'Com_alter_procedure');
        $startAlterServer = $this->getValueIfExist($startQueries, 'Com_alter_server');
        $startAlterTable = $this->getValueIfExist($startQueries, 'Com_alter_table');
        $startAlterTableSpace = $this->getValueIfExist($startQueries, 'Com_alter_tablespace');
        $startAlterUser = $this->getValueIfExist($startQueries, 'Com_alter_user');

        $startDropDb = $this->getValueIfExist($startQueries, 'Com_drop_db');
        $startDropEvent = $this->getValueIfExist($startQueries, 'Com_drop_event');
        $startDropFunc = $this->getValueIfExist($startQueries, 'Com_drop_function');
        $startDropIndex = $this->getValueIfExist($startQueries, 'Com_drop_index');
        $startDropProcedure = $this->getValueIfExist($startQueries, 'Com_drop_procedure');
        $startDropServer = $this->getValueIfExist($startQueries, 'Com_drop_server');
        $startDropTable = $this->getValueIfExist($startQueries, 'Com_drop_table');
        $startDropTrigger = $this->getValueIfExist($startQueries, 'Com_drop_trigger');
        $startDropUser = $this->getValueIfExist($startQueries, 'Com_drop_user');
        $startDropView = $this->getValueIfExist($startQueries, 'Com_drop_view');

        sleep($sleep);

        // end queries
        $endQueries = $this->baseSchema->rawQuery('show global status');
        $endSelect = $this->getValueIfExist($endQueries, 'Com_select');
        $endUpdate = $this->getValueIfExist($endQueries, 'Com_update');
        $endInsert = $this->getValueIfExist($endQueries, 'Com_insert');
        $endDelete = $this->getValueIfExist($endQueries, 'Com_delete');
        $endByteSent = $this->getValueIfExist($endQueries, 'Bytes_sent');
        $endByteReceived = $this->getValueIfExist($endQueries, 'Bytes_received');
        $endConnections = $this->getValueIfExist($endQueries, 'Connections');
        $endAbortedClients = $this->getValueIfExist($endQueries, 'Aborted_clients');
        $endAbortedConnections = $this->getValueIfExist($endQueries, 'Aborted_connects');

        $endCreateDb = $this->getValueIfExist($endQueries, 'Com_create_db');
        $endCreateEvent = $this->getValueIfExist($endQueries, 'Com_create_event');
        $endCreateFunc = $this->getValueIfExist($endQueries, 'Com_create_function');
        $endCreateProcedure = $this->getValueIfExist($endQueries, 'Com_create_procedure');
        $endCreateServer = $this->getValueIfExist($endQueries, 'Com_create_server');
        $endCreateTable = $this->getValueIfExist($endQueries, 'Com_create_table');
        $endCreateTrigger = $this->getValueIfExist($endQueries, 'Com_create_trigger');
        $endCreateUDF = $this->getValueIfExist($endQueries, 'Com_create_udf');
        $endCreateUser = $this->getValueIfExist($endQueries, 'Com_create_user');
        $endCreateView = $this->getValueIfExist($endQueries, 'Com_create_view');

        $endAlterDb = $this->getValueIfExist($endQueries, 'Com_alter_db');
        $endAlterDbUpgrade = $this->getValueIfExist($endQueries, 'Com_alter_db_upgrade');
        $endAlterEvent = $this->getValueIfExist($endQueries, 'Com_alter_event');
        $endAlterFunc = $this->getValueIfExist($endQueries, 'Com_alter_function');
        $endAlterProcedure = $this->getValueIfExist($endQueries, 'Com_alter_procedure');
        $endAlterServer = $this->getValueIfExist($endQueries, 'Com_alter_server');
        $endAlterTable = $this->getValueIfExist($endQueries, 'Com_alter_table');
        $endAlterTableSpace = $this->getValueIfExist($endQueries, 'Com_alter_tablespace');
        $endAlterUser = $this->getValueIfExist($endQueries, 'Com_alter_user');

        $endDropDb = $this->getValueIfExist($startQueries, 'Com_drop_db');
        $endDropEvent = $this->getValueIfExist($startQueries, 'Com_drop_event');
        $endDropFunc = $this->getValueIfExist($startQueries, 'Com_drop_function');
        $endDropIndex = $this->getValueIfExist($startQueries, 'Com_drop_index');
        $endDropProcedure = $this->getValueIfExist($startQueries, 'Com_drop_procedure');
        $endDropServer = $this->getValueIfExist($startQueries, 'Com_drop_server');
        $endDropTable = $this->getValueIfExist($startQueries, 'Com_drop_table');
        $endDropTrigger = $this->getValueIfExist($startQueries, 'Com_drop_trigger');
        $endDropUser = $this->getValueIfExist($startQueries, 'Com_drop_user');
        $endDropView = $this->getValueIfExist($startQueries, 'Com_drop_view');

        $timeSpan = (microtime(true) - $uptimeStart);

        return [
            [
                'Select', round(($endSelect - $startSelect) / $timeSpan).' QPS',
                'DB', round(($endCreateDb - $startCreateDb) / $timeSpan).' PS',
                'DB', round(($endAlterDb - $startAlterDb) / $timeSpan).' PS',
                'DB', round(($endDropDb - $startDropDb) / $timeSpan).' PS',

            ],
            ['', '', '', '', '', '', '', ''],
            [
                'Update', round(($endUpdate - $startUpdate) / $timeSpan).' QPS',
                'Event', round(($endCreateEvent - $startCreateEvent) / $timeSpan).' PS',
                'DB Upgrade', round(($endAlterDbUpgrade - $startAlterDbUpgrade) / $timeSpan).' PS',
                'Event', round(($endDropEvent - $startDropEvent) / $timeSpan).' PS',
            ],
            ['', '', '', '', '', '', '', ''],
            [
                'Insert', round(($endInsert - $startInsert) / $timeSpan).' QPS',
                'Function', round(($endCreateFunc - $startCreateFunc) / $timeSpan).' PS',
                'DB Event', round(($endAlterEvent - $startAlterEvent) / $timeSpan).' PS',
                'Function', round(($endDropFunc - $startDropFunc) / $timeSpan).' PS',
            ],
            ['', '', '', '', '', '', '', ''],
            [
                'Delete', round(($endDelete - $startDelete) / $timeSpan).' QPS',
                'Procedure', round(($endCreateProcedure - $startCreateProcedure) / $timeSpan).' PS',
                'Function', round(($endAlterFunc - $startAlterFunc) / $timeSpan).' PS',
                'Index', round(($endDropIndex - $startDropIndex) / $timeSpan).' PS',
            ],
            ['', '', '', '', '', '', '', ''],
            [
                'Payload sent', $this->formatBytes(round(($endByteSent - $startByteSent) / $timeSpan)).'/s',
                'Server', round(($endCreateServer - $startCreateServer) / $timeSpan).' PS',
                'Procedure', round(($endAlterProcedure - $startAlterProcedure) / $timeSpan).' PS',
                'Procedure', round(($endDropProcedure - $startDropProcedure) / $timeSpan).' PS',
            ],
            ['', '', '', '', '', '', '', ''],
            [
                'Payload received', $this->formatBytes(round(($endByteReceived - $startByteReceived) / $timeSpan)).'/s',
                'Table', round(($endCreateTable - $startCreateTable) / $timeSpan).' PS',
                'Procedure', round(($endAlterProcedure - $startAlterProcedure) / $timeSpan).' PS',
                'Server', round(($endDropServer - $startDropServer) / $timeSpan).' PS',
            ],
            ['', '', '', '', '', '', '', ''],
            [
                'Connections', round(($endConnections - $startConnections) / $timeSpan).' PS ',
                'Trigger', round(($endCreateTrigger - $startCreateTrigger) / $timeSpan).' PS',
                'Server', round(($endAlterServer - $startAlterServer) / $timeSpan).' PS',
                'Table', round(($endDropTable - $startDropTable) / $timeSpan).' PS',

            ],
            ['', '', '', '', '', '', '', ''],
            [
                'Total Connections', round($endConnections),
                'UDF', round(($endCreateUDF - $startCreateUDF) / $timeSpan).' PS',
                'Table', round(($endAlterTable - $startAlterTable) / $timeSpan).' PS',
                'Trigger', round(($endDropTrigger - $startDropTrigger) / $timeSpan).' PS',
            ],
            ['', '', '', '', '', '', '', ''],
            [
                'Aborted Clients', round(($endAbortedClients - $startAbortedClients) / $timeSpan).' PS',
                'User', round(($endCreateUser - $startCreateUser) / $timeSpan).' PS',
                'TableSpace', round(($endAlterTableSpace - $startAlterTableSpace) / $timeSpan).' PS',
                'User', round(($endDropUser - $startDropUser) / $timeSpan).' PS',
            ],
            ['', '', '', '', '', '', '', ''],
            [
                'Aborted Connections', round(($endAbortedConnections - $startAbortedConnections) / $timeSpan).' PS',
                'View', round(($endCreateView - $startCreateView) / $timeSpan).' PS',
                'User', round(($endAlterUser - $startAlterUser) / $timeSpan).' PS',
                'View', round(($endDropView - $startDropView) / $timeSpan).' PS',
            ],
        ];
    }
}
