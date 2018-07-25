<?php

date_default_timezone_set('Asia/Shanghai');

define('PUBLIC_PATH', __DIR__);

$project_name = isset($_GET['app']) && in_array($_GET['app'], ['admin','api','apiv2','wechat','test']) ? $_GET['app'] : 'admin';

define('PROJECT_NAME', $project_name);

require_once '../init.php';

require_once TPR_PATH . 'start.php';