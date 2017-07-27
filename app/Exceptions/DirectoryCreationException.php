<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 27.07.17
 * Time: 10:25
 */

namespace PhotoDownload\Exceptions;


/**
 * Class DirectoryCreationException
 * @package PhotoDownload\Exceptions
 */
class DirectoryCreationException extends \Exception
{
    /**
     * DirectoryCreationException constructor.
     * @param null $message
     * @param null $code
     * @param null $prev
     */
    public function __construct($message = null, $code = null, $prev = null)
    {
        parent::__construct($message, $code, $prev);
    }
}