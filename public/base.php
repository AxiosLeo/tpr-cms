<?php

namespace tpr\index;

use tpr\App;
use tpr\Path;

require_once __DIR__ . '/../vendor/autoload.php';

Path::configurate([
    'app'     => 'application' . \DIRECTORY_SEPARATOR . APP_NAME,
    'runtime' => 'runtime' . \DIRECTORY_SEPARATOR . APP_NAME,
    'views'   => 'views' . \DIRECTORY_SEPARATOR . APP_NAME,
]);

App::debugMode(true);

App::default()->config([
    'name'      => APP_NAME,
    'namespace' => APP_NAME,
])->run();
