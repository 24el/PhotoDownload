<?php
namespace PhotoDownload\Creators;

use GuzzleHttp\Client;
use PhotoDownload\Exceptions\AlbumsNotFoundException;
use PhotoDownload\Models\Album;
use PhotoDownload\Models\User;

/**
 * Class AlbumCreator
 * @package PhotoDownload\Creators
 */
class AlbumCreator
{

    private $owner;
    private $dir;

    /**
     * AlbumCreator constructor.
     * @param $id
     * @param $owner
     */
    public function __construct(User $owner, $dir = null)
    {
        $this->owner = $owner;
        $this->dir = $dir;
    }

    /**
     * Create new Album Object
     *
     * @param $albumId
     * @param $albumName
     * @param $description
     * @return Album
     */
    public function createAlbum($albumId, $albumName, $description){
        return new Album($albumId, $this->getOwner(), $albumName, $description, $this->getDir());
    }

    /**
     * Albums array iteration
     *
     * @param $albumsArr
     * @return array
     */
    public function getAlbums($albumsArr){
        $albumsObjArr = array();
        foreach ($albumsArr as $album){
            $albObj = $this->createAlbum($album->id, $album->title, $album->description);
            array_push($albumsObjArr, $albObj);
        }
        return $albumsObjArr;
    }

    /**
     * Getting Albums from VK API
     *
     * @return mixed
     * @throws AlbumsNotFoundException
     */
    public function getAlbumsInfoFromApi(){
        $client = new Client();
        //Request sending
        $res = $client->request('GET', 'https://api.vk.com/method/photos.getAlbums', [
            'query' => [
                'owner_id' => $this->owner->getId(),
                'v' => '5.52']
        ]);
        //Generationg json object from response body
        $albumsJsonObj = json_decode($res->getBody());

        //Available albums check
        if($albumsJsonObj->response->count > 0){
            $albumsArr = $albumsJsonObj->response->items;
            return $albumsArr;
        }else{
            throw new AlbumsNotFoundException("User havent any public album");
        }
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @return null
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * @param User $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @param null $dir
     */
    public function setDir($dir)
    {
        $this->dir = $dir;
    }


}