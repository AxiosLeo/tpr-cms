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
define('PROJECT_NAME', 'rabbit');

require_once '../../init.php';
require THINK_PATH . '/base.php';
require '../lib/Rabbitmq.php';

Rabbitmq::run();