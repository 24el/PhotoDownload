<?php

namespace PhotoDownload\Savers;

use PhotoDownload\Models\Model;


/**
 * Interface DirectorySaver
 * @package PhotoDownload\Savers
 */
interface DirectorySaver
{
    /**
     * @param Model $model
     * @return mixed
     */
    public function save(Model $model);

}