<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/10/26 上午9:18
 */

/**
 * 需要gearman的php扩展
 * 安装示例 https://hanxv.cn/archives/25.html#gearman
 */

use server\lib\Gearman;

date_default_timezone_set('Asia/Shanghai');

define('PROJECT_NAME', 'server');

require_once '../../init.php';
require THINK_PATH . '/base.php';
require '../lib/Gearman.php';

Gearman::run();