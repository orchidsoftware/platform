<?php namespace Orchid\Schema;


/**
 * Interface WrapperContract
 * @package Orchid\Schema
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