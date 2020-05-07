<?php

namespace tpr\index;

use tpr\App;
use tpr\Path;

require_once __DIR__ . '/../vendor/autoload.php';

Path::$subPath = APP_NAME;

App::debugMode(true);
$app = App::default();
$app->setOption('name', APP_NAME);
$app->setOption('namespace', APP_NAME);

$app->run();
