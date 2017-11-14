<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/10/25 上午10:10
 */

/**
 * need tpr-framework:^1.1.6
 */

use server\lib\Workman;

date_default_timezone_set('Asia/Shanghai');

define('PUBLIC_PATH',__DIR__);
define('PROJECT_NAME', 'server');

require_once __DIR__ . '/../../init.php';
require THINK_PATH . '/base.php';
require __DIR__ . '/../lib/Workman.php';

Workman::run();
