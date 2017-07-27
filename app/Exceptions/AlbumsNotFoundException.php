<?php

namespace PhotoDownload\Exceptions;


/**
 * Class AlbumsNotFoundException
 * @package PhotoDownload\Exceptions
 */
class AlbumsNotFoundException extends \Exception
{

    /**
     * AlbumsNotFoundException constructor.
     * @param null $message
     * @param null $code
     * @param null $prev
     */
    public function __construct($message = null, $code = null, $prev = null)
    {
        parent::__construct($message, $code, $prev);
    }
}