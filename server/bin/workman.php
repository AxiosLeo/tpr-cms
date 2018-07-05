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


date_default_timezone_set('Asia/Shanghai');

define('PUBLIC_PATH',__DIR__);
define('PROJECT_NAME', 'server');

require_once __DIR__ . '/../../init.php';
require TPR_PATH . '/base.php';
require __DIR__ . '/../../library/extend/workman/Workman.php';

\library\extend\workman\Workman::run();
