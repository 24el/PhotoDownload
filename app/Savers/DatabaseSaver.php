<?php

namespace PhotoDownload\Savers;


/**
 * Interface DatabaseSaver
 * @package PhotoDownload\Savers
 */
interface DatabaseSaver
{
    /**
     * @param $tableName
     * @param array $columnNames
     * @param array $values
     * @return mixed
     */
    public function save($tableName, $columnNames = [], $values = []);
}