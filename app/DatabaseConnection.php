<?php
namespace PhotoDownload;

/**
 * Class DatabaseConnection
 * @package PhotoDownload
 */
class DatabaseConnection
{
    static private $instance = null;

    private $pdo = null;
    private $username = 'root';
    private $password = '';
    private $opt = [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];

    private function __construct() { /* ... @return Singleton */ }
    private function __clone() { /* ... @return Singleton */ }
    private function __wakeup() { /* ... @return Singleton */ }

    /**
     * @return null|static
     */
    static public function getInstance() {
        return
            self::$instance===null
                ? self::$instance = new static()
                : self::$instance;
    }

    public function getPDOConnection(){
            if($this->pdo===null){
                try {
                    //Creating MySql connection if it's not exist
                    $this->pdo = new \PDO('mysql:host=127.0.0.1;dbname=PhotoDownload',
                        $this->username, $this->password, $this->opt);
                    $this->pdo->exec( "SET CHARSET utf8" );
                    return $this->pdo;
                }catch (PDOException $e){
                    die('Подключение не удалось: ' . $e->getMessage());
                }
            }else{
                return $this->pdo;
            }

    }
}
