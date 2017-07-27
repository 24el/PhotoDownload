<?php
require_once dirname(__FILE__).'/../app/DatabaseConnection.php';

class UsersTableCreator
{
    public function create()
    {
        $pdo = DatabaseConnection::getInstance()->getPDOConnection();
        $stmt = $pdo->prepare("CREATE TABLE `users` (
            `id` INT(11) UNSIGNED NOT NULL,
            `name` VARCHAR(50) NOT NULL,
            `last_name` VARCHAR(50) NOT NULL,
            PRIMARY KEY (`id`)
        )
        COLLATE='utf8_general_ci'
        ENGINE=InnoDB");
        $stmt->execute();
    }

    public function drop(){
        $pdo = DatabaseConnection::getInstance()->getPDOConnection();
        $stmt = $pdo->prepare("DROP TABLE users");
        $stmt->execute();
    }
}