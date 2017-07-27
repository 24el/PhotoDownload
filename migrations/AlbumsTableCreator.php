<?php
require_once dirname(__FILE__).'/../app/DatabaseConnection.php';

class AlbumsTableCreator
{
    public function create()
    {
        $pdo = DatabaseConnection::getInstance()->getPDOConnection();
        $stmt = $pdo->prepare("CREATE TABLE `albums` (
            `id` INT(11) UNSIGNED NOT NULL,
            `owner_id` INT(11) UNSIGNED NOT NULL,
            `name` VARCHAR(100) NOT NULL,
            `local_dir` VARCHAR(100) NOT NULL,
            `description` TEXT NOT NULL,
            PRIMARY KEY (`id`),
            INDEX `album_owner` (`owner_id`),
            CONSTRAINT `owner_id` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
        )
        COLLATE='utf8_general_ci'
        ENGINE=InnoDB");
        $stmt->execute();
    }

    public function drop(){
        $pdo = DatabaseConnection::getInstance()->getPDOConnection();
        $stmt = $pdo->prepare("DROP TABLE albums");
        $stmt->execute();
    }
}