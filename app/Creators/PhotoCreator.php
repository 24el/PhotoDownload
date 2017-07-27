<?php
namespace PhotoDownload\Creators;

use GuzzleHttp\Client;
use PhotoDownload\Models\Album;
use PhotoDownload\Models\Photo;


/**
 * Class PhotoCreator
 * @package PhotoDownload\Creators
 */
class PhotoCreator
{
    private $album;

    /**
     * PhotoCreator constructor.
     * @param $album
     */
    public function __construct(Album $album)
    {
        $this->album = $album;
    }

    /**
     * Create Photo Object
     *
     * @param $photoId
     * @param Album $album
     * @param $ref
     * @param $text
     * @return Photo
     */
    public function createPhoto($photoId, Album $album, $ref, $text)
    {
        return new Photo($photoId, $album, $ref, $text);
    }

    /**
     * Photos array iteration and object creation
     *
     * @param $photosArr
     * @return array
     */
    public function getPhotos($photosArr)
    {
        $photosObjArr = array();
        foreach ($photosArr as $photo) {
            $photoObj = $this->createPhoto($photo->id, $this->album,
                isset($photo->photo_1280) ? $photo->photo_1280 : $photo->photo_604, $photo->text);
            array_push($photosObjArr, $photoObj);
        }
        return $photosObjArr;
    }

    /**
     * Getting Albums from VK API
     *
     * @return mixed
     */
    public function getPhotosInfoFromApi()
    {
        $client = new Client();
        //Request sending
        $res = $client->request('GET', 'https://api.vk.com/method/photos.get', [
            'query' => [
                'owner_id' => $this->album->getOwner()->getId(),
                'album_id' => $this->album->getId(),
                'v' => '5.52']
        ]);
        //Creatin json object from response body
        $photosJsonObj = json_decode($res->getBody());

        //Check photos number
        if ($photosJsonObj->response->count > 0) {
            $photosArr = $photosJsonObj->response->items;
            return $photosArr;
        } else {
            echo "Album with such id contains no photos\n";
        }
    }

    /**
     * @return Album
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @param Album $album
     */
    public function setAlbum($album)
    {
        $this->album = $album;
    }


}