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

define('PROJECT_NAME', 'server');

require_once __DIR__ . '/../../init.php';
require THINK_PATH . '/base.php';
require __DIR__ . '/../lib/Gearman.php';

Gearman::run();