<?php

date_default_timezone_set('Asia/Shanghai');

define('PUBLIC_PATH', __DIR__);
define("APP_KEY",'y8kA7atkk7TrCgS8orObNnXMl54QlBnS');

$project_name = isset($_GET[APP_KEY]) && in_array($_GET[APP_KEY], ['admin', 'api', 'apiv2', 'wechat', 'test']) ? $_GET[APP_KEY] : 'admin';
unset($_GET[APP_KEY]);
define('PROJECT_NAME', $project_name);

/**
    #nginx config
    location /api/ {
        rewrite ^(.*)$ /index.php?y8kA7atkk7TrCgS8orObNnXMl54QlBnS=api last;
        break;
    }
*/

require_once '../init.php';

require_once TPR_PATH . 'start.php';