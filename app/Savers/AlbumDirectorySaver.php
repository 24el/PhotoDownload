<?php

namespace PhotoDownload\Savers;


use PhotoDownload\Exceptions\DirectoryCreationException;
use PhotoDownload\Models\Album;

/**
 * Class AlbumDirectorySaver
 * @package PhotoDownload\Savers
 */
class AlbumDirectorySaver
{
    /**
     * Creates directory by the album path
     *
     * @param $album
     * @return bool
     * @throws DirectoryCreationException
     */
    public function save(Album $album)
    {
        echo "Album ".$album->getName()."\n";
        //Creating directory new directory
        if(!file_exists($album->getDirPath())){
            if(mkdir($album->getDirPath(), 0777, true)){
                return true;
            }
        //Check files in directory
        }elseif(count(scandir($album->getDirPath())) <= 2){
            return true;
        }
        else{
            throw new DirectoryCreationException("Cannot create directory by inserted path
             or directory already exists and has files\n");
        }
    }
}