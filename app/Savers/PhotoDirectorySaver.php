<?php

namespace PhotoDownload\Savers;


use PhotoDownload\Models\Photo;

/**
 * Class PhotoDirectorySaver
 * @package PhotoDownload\Savers
 */
class PhotoDirectorySaver
{

    /**
     * Saves photos by the link to the album directory
     * @param $photo
     */
    public function save(Photo $photo){
        copy($photo->getPhotoRef(),
            $photo->getAlbum()->getDirPath().'/'.$photo->getId());
    }
}