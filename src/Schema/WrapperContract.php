<?php

namespace Orchid\Schema;

/**
 * Interface WrapperContract.
 */
interface WrapperContract
{
    /**
     * @return mixed
     */
    public function getTables();

    /**
     * @param $tableName
     * @return mixed
     */
    public function getColumns($tableName);

    /**
     * @return mixed
     */
    public function getSchema();
}
