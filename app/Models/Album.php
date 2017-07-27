<?php
namespace PhotoDownload\Models;

use PhotoDownload\Savers\AlbumDirectorySaver;
use PhotoDownload\Savers\DatabaseSaver;


/**
 * Class Album
 * @package PhotoDownload\Models
 */
class Album implements Model
{
    private $tableName = "albums";

    private $id;
    private $owner;
    private $name;
    private $description;
    private $dirPath;

    private $photos = array();

    /**
     * Album constructor.
     * @param $id
     * @param $owner
     * @param $name
     */
    public function __construct($id, User $owner, $name, $description, $path)
    {
        $this->id = $id;
        $this->owner = $owner;
        $this->name = $name;
        $this->description = $description;
        $this->dirPath = $this->generateAlbumPath($path);
    }

    /**
     * Saves album
     *
     * @param DatabaseSaver $dbSaver
     * @return bool
     */
    public function save(DatabaseSaver $dbSaver)
    {
        $dirSaver = new AlbumDirectorySaver();
        $columns = [
            'id',
            'owner_id',
            'name',
            'local_dir',
            'description'
        ];
        $values = [
            $this->getId(),
            $this->getOwner()->getId(),
            $this->getName(),
            $this->getDirPath(),
            $this->getDescription()
        ];
        //Saving to database
        if($dbSaver->save($this->getTableName(), $columns, $values)){
            //Saving to directory
            $dirSaver->save($this);
            return true;
        }
        return false;
    }

    /**
     * Generates album directory path
     *
     * @param $path
     * @return string
     */
    public function generateAlbumPath($path)
    {
        $albumName = $this->getOwner()->getLastName().'-'.
            $this->getOwner()->getName().'_'.$this->getName();
        return ($path) ? $path.$albumName : $albumName;
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
    public function getDirPath()
    {
        return $this->dirPath;
    }

    /**
     * @return mixed
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @param mixed $photos
     */
    public function setPhotos($photos)
    {
        array_push($this->photos, $photos);
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
    public function getOwner()
    {
        return $this->owner;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $tableName
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param User $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param string $dirPath
     */
    public function setDirPath($dirPath)
    {
        $this->dirPath = $dirPath;
    }


}