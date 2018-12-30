<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018-12-31 00:20
 */

date_default_timezone_set('Asia/Shanghai');

define('PUBLIC_PATH', __DIR__);
define('PROJECT_NAME', 'server');

$root = dirname(dirname(dirname(__DIR__)));
require_once $root . '/init.php';
require TPR_PATH . '/base.php';
require $root . '/library/extend/workman/Workman.php';

\library\extend\workman\Workman::run();