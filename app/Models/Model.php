<?php

namespace PhotoDownload\Models;


use PhotoDownload\Savers\DatabaseSaver;

interface Model
{
    public function save(DatabaseSaver $ds);
}