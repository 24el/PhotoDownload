<?php
require_once dirname(__FILE__).'/../app/DatabaseConnection.php';

class PhotosTableCreator
{
    public function create()
    {
        $pdo = DatabaseConnection::getInstance()->getPDOConnection();
        $stmt = $pdo->prepare("CREATE TABLE `photos` (
            `id` INT(11) UNSIGNED NOT NULL,
            `album_id` INT(11) UNSIGNED NOT NULL,
            `reference` VARCHAR(100) NOT NULL,
            PRIMARY KEY (`id`),
            INDEX `photo_album` (`album_id`),
            CONSTRAINT `album_id` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
        )
        COLLATE='utf8_general_ci'
        ENGINE=InnoDB");
        $stmt->execute();
    }

    public function drop(){
        $pdo = DatabaseConnection::getInstance()->getPDOConnection();
        $stmt = $pdo->prepare("DROP TABLE photos");
        $stmt->execute();
    }

}