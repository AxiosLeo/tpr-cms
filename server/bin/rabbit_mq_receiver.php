<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/11/8 09:55
 */

use server\lib\Rabbitmq;

define('PUBLIC_PATH',__DIR__);
define('PROJECT_NAME', 'server');

require_once __DIR__ . '/../../init.php';
require THINK_PATH . '/base.php';
require __DIR__ . '/../lib/Rabbitmq.php';

Rabbitmq::run();