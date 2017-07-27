<?php
require_once dirname(__FILE__).'/../app/DatabaseConnection.php';

class PhotoTextTableCreator
{
    public function create()
    {
        $pdo = DatabaseConnection::getInstance()->getPDOConnection();
                    $stmt = $pdo->prepare("CREATE TABLE `photo_text` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `photo_id` INT(11) NOT NULL DEFAULT '0',
                `text` TEXT NOT NULL COLLATE 'cp1251_general_ci',
                PRIMARY KEY (`id`),
                INDEX `photo_id` (`photo_id`),
                CONSTRAINT `photo_id` FOREIGN KEY (`photo_id`) REFERENCES `photos` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
            )
            COLLATE='cp1251_general_ci'
            ENGINE=InnoDB");
        $stmt->execute();
    }

    public function drop(){
        $pdo = DatabaseConnection::getInstance()->getPDOConnection();
        $stmt = $pdo->prepare("DROP TABLE photo_text");
        $stmt->execute();
    }

}