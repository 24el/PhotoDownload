<?php

namespace PhotoDownload\Savers;

use PhotoDownload\DatabaseConnection;

/**
 * Class MysqlSaver
 * @package PhotoDownload\Savers
 */
class MysqlSaver implements DatabaseSaver
{

    /**
     * Save to MySql by passed table name, columns and values
     *
     * @param $tableName
     * @param array $columnNames
     * @param array $values
     * @return bool
     */
    public function save($tableName, $columnNames = [], $values = [])
    {
        //Geting PDO connection
        $pdo = DatabaseConnection::getInstance()->getPDOConnection();
        //Creating associative array used to bind params
        $bindParamsArr = array_combine($columnNames, $values);
        $dotedBindParams = array();
        //Creating list of columns used in query
        $columnNamesStr = implode(', ', $columnNames);
        //Creating list of params to bind
        foreach($columnNames as $columnName){
            array_push($dotedBindParams, ":".$columnName);
        }
        $bindKeysStr = implode(', ', $dotedBindParams);
        //Generating query
        $query = "INSERT INTO `".$tableName."`(".$columnNamesStr.") ".
            "VALUES(".$bindKeysStr.")";
        $stmt = $pdo->prepare($query);
        //Query execution
        if($stmt->execute($bindParamsArr)){
            return true;
        }
        return false;
    }
}