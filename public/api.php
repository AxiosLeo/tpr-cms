<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018-12-13 09:59
 */

namespace think;

date_default_timezone_set('Asia/Shanghai');

define('DS', DIRECTORY_SEPARATOR);
define('PUBLIC_PATH', __DIR__);
define('PROJECT_NAME', 'api');
define('APP_NAMESPACE', 'tpr\\' . PROJECT_NAME);
define('ROOT_PATH', dirname(__DIR__) . DS);
define('CONFIG_PATH', ROOT_PATH . 'config' . DS);
define('APP_PATH', ROOT_PATH . 'application' . DS . PROJECT_NAME . DS);
define('RUNTIME_PATH', ROOT_PATH . 'runtime' . DS . PROJECT_NAME . DS);
define('ROUTE_PATH', ROOT_PATH . 'route' . DS . PROJECT_NAME . DS);

// 加载基础文件
require __DIR__ . '/../vendor/axios/tp5/base.php';
//require __DIR__ . '/../framework/base.php';

Loader::addNamespace('library', ROOT_PATH . 'library' . DS);

// 支持事先使用静态方法设置Request对象和Config对象
// 执行应用并响应
/* @var App $app */
Container::get('app', [APP_PATH])->run()->send();