<?php

namespace tpr\index;

use tpr\App;
use tpr\Event;
use tpr\Path;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require_once __DIR__ . '/../vendor/autoload.php';

Path::root(realpath(dirname(__DIR__)) . \DIRECTORY_SEPARATOR);
Path::vendor(Path::root() . 'vendor' . \DIRECTORY_SEPARATOR);
Path::app(Path::root() . 'application' . \DIRECTORY_SEPARATOR . APP_NAME);
Path::config(Path::root() . 'config' . \DIRECTORY_SEPARATOR . APP_NAME);
Path::cache(Path::root() . 'runtime' . \DIRECTORY_SEPARATOR . APP_NAME);
Path::views(Path::root() . 'views' . \DIRECTORY_SEPARATOR . APP_NAME);

$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

App::debugMode(true);
$app = App::default();
$app->setOption('name', APP_NAME);
$app->setOption("namespace", APP_NAME);

if (file_exists(Path::app() . \DIRECTORY_SEPARATOR . 'helper.php')) {
    require_once Path::app() . \DIRECTORY_SEPARATOR . 'helper.php';
}

$app->run();
