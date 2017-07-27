<?php
namespace PhotoDownload\Models;

use GuzzleHttp\Client;
use PhotoDownload\Savers\DatabaseSaver;


/**
 * Class User
 * @package PhotoDownload\Models
 */
class User implements Model
{
    private $tableName = "users";

    private $id;
    private $name;
    private $lastName;

    /**
     * User constructor.
     * @param $id
     * @param $name
     * @param $lastName
     */
    public function __construct(int $id)
    {
        if(is_integer($id)) {
            $this->id = $id;
        } else{
            throw new \InvalidArgumentException("Id must be integer");
        }
    }

    /**
     * Database saving
     *
     * @param DatabaseSaver $dbSaver
     */
    public function save(DatabaseSaver $dbSaver)
    {
        $columns = [
            'id',
            'name',
            'last_name'
        ];
        $values = [
            $this->getId(),
            $this->getName(),
            $this->getLastName()
        ];
        $dbSaver->save($this->getTableName(), $columns, $values);
    }

    /**
     * Get user info from VK API
     */
    public function getUserInfoFromApi()
    {
        $client = new Client();
        //Request sending
        $res = $client->request('GET', 'https://api.vk.com/method/users.get', [
            'query' => [
                'user_id' => $this->getId(),
                'v' => '5.52']
        ]);
        //Generationg json object from response body
        $userArr = json_decode($res->getBody());
        if(isset($userArr->response[0])){
            $this->setName($userArr->response[0]->first_name);
            $this->setLastName($userArr->response[0]->last_name);
        }else{
            throw new \InvalidArgumentException("User with that id doesnt exist");
        }
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    /**
     * @param string $tableName
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

}