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

// 加载TPR-Behavior
//require_once ROOT_PATH.DIRECTORY_SEPARATOR."thinkphp".DIRECTORY_SEPARATOR."library".DIRECTORY_SEPARATOR."think".DIRECTORY_SEPARATOR."Hook.php";
//\think\Hook::add('app_init' ,'axios\\tpr\\behavior\\AppInit');
//\think\Hook::add('action_begin' ,'axios\\tpr\\behavior\\ActionBegin');
//\think\Hook::add('app_end' ,'axios\\tpr\\behavior\\AppEnd');

// 加载公共语言包
//require_once ROOT_PATH.DIRECTORY_SEPARATOR."thinkphp".DIRECTORY_SEPARATOR."library".DIRECTORY_SEPARATOR."think".DIRECTORY_SEPARATOR."Lang.php";
//\think\Lang::load(CONF_PATH.'lang'.DIRECTORY_SEPARATOR);

//引入公共方法文件
//include_once CONF_PATH.'common.php';

// 加载框架引导文件
require THINK_PATH  . 'start.php';
