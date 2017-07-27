<?php
//Autoloader set
require __DIR__.'/vendor/autoload.php';

use PhotoDownload\Commands\PhotoDownloadCommand;
use Symfony\Component\Console\Application;

//Application creation
$application = new Application();
//Setting command
$application->add(new PhotoDownloadCommand());
//Application start
$application->run();