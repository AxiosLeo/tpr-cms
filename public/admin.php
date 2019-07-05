<?php
namespace tpr;

require_once __DIR__ . '/../init.php';

Path::app(Path::dir([
    dirname(__DIR__),
    "application",
    "admin"
]));

App::setAppOption("namespace", "App\\admin\\");
App::run(true);