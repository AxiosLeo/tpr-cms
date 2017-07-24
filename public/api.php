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
define('APP_PATH', ROOT_PATH . 'api/');
//define('CONF_PATH', ROOT_PATH.'config/');
define('RUNTIME_PATH', ROOT_PATH . 'runtime/api/');
define('APP_NAMESPACE','api');
define('THINK_PATH', ROOT_PATH . 'vendor/axios/tpr-framework/');


// 加载框架引导文件
require THINK_PATH  . 'start.php';
