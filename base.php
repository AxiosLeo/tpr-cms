<?php

namespace tpr\index;

use tpr\App;
use tpr\Config;
use tpr\Path;

$autoload_file = __DIR__ . \DIRECTORY_SEPARATOR . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';

if (!\defined('APP_NAME')) {
    exit(0);
}

if (!file_exists($autoload_file)) {
    echo 'Please install composer libraries with command : `composer install`';

    exit();
}

require_once __DIR__ . \DIRECTORY_SEPARATOR . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';

// use debug mode
App::debugMode(true);

Path::configurate([
    'app'     => 'application' . \DIRECTORY_SEPARATOR . APP_NAME,
    'runtime' => 'runtime' . \DIRECTORY_SEPARATOR . APP_NAME,
    'views'   => 'views' . \DIRECTORY_SEPARATOR . APP_NAME,
    'config'  => 'config' . \DIRECTORY_SEPARATOR . APP_NAME,
]);

// init app
$app = App::default();

// load global config
Config::load(Path::join(Path::root(), 'config/global'));
