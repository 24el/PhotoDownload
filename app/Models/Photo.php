<?php
namespace PhotoDownload\Models;

use PhotoDownload\Savers\DatabaseSaver;
use PhotoDownload\Savers\PhotoDirectorySaver;

/**
 * Class Photo
 * @package PhotoDownload\Models
 */
class Photo implements Model
{
    private $tableName = "photos";

    private $id;
    private $album;
    private $photoRef;
    private $text;

    /**
     * Photo constructor.
     * @param $id
     * @param $owner
     * @param $album
     * @param $photoRef
     */
    public function __construct($id, Album $album, $photoRef, $text)
    {
        $this->id = $id;
        $this->album = $album;
        $this->photoRef = $photoRef;
        $this->text = $text;
    }

    /**
     * Save photo
     *
     * @param DatabaseSaver $dbSaver
     */
    public function save(DatabaseSaver $dbSaver)
    {
        $dirSaver = new PhotoDirectorySaver();
        $columns = [
            'id',
            'album_id',
            'reference'
        ];
        $values = [
            $this->getId(),
            $this->getAlbum()->getId(),
            $this->getPhotoRef()
        ];
        //Saving to database
        if($dbSaver->save($this->getTableName(), $columns, $values)){
            //Saving photo text to database
            if($this->getText() != null) {
                $this->savePhotoText($dbSaver);
            }
            //Saving to directory
            $dirSaver->save($this);
        }
    }

    /**
     * Saves photo text to database
     *
     * @param DatabaseSaver $dbSaver
     */
    public function savePhotoText(DatabaseSaver $dbSaver)
    {
        $tableName = "photo_text";
        $columns = [
            'photo_id',
            'text'
        ];
        $values = [
            $this->id,
            $this->text
        ];
        //Saving to database
        $dbSaver->save($tableName, $columns, $values);
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
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @return mixed
     */
    public function getPhotoRef()
    {
        return $this->photoRef;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
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
     * @param Album $album
     */
    public function setAlbum($album)
    {
        $this->album = $album;
    }

    /**
     * @param mixed $photoRef
     */
    public function setPhotoRef($photoRef)
    {
        $this->photoRef = $photoRef;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

}