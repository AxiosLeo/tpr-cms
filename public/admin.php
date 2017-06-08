<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 定义应用目录
define('ROOT_PATH',__DIR__.'/../');
define('APP_PATH', ROOT_PATH . 'admin/');
define('CONF_PATH', ROOT_PATH.'config/');
define('RUNTIME_PATH', ROOT_PATH . 'runtime/admin/');
define('APP_NAMESPACE','admin');

// 加载公共语言包
require_once ROOT_PATH.DIRECTORY_SEPARATOR."thinkphp".DIRECTORY_SEPARATOR."library".DIRECTORY_SEPARATOR."think".DIRECTORY_SEPARATOR."Lang.php";
\think\Lang::load(CONF_PATH.'lang'.DIRECTORY_SEPARATOR);

//引入公共方法文件
include_once CONF_PATH.'common.php';

// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';