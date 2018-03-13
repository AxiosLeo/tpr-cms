<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 10:28
 */
return [
    // 应用调试模式
    'app_debug' => \think\Env::get('global.debug',true),

    // 异常处理handle类 留空使用
    'exception_handle' => 'library\\exception\\HttpException',


    // 是否自动转换URL中的控制器和操作名
    'url_convert' => false,

    'admin' => [
        'themes' => 'default'
    ],

    'log' => [
        // 日志记录方式，内置 file socket 支持扩展
        'type' => 'File',
        // 日志保存目录
        'path' => LOG_PATH,
        // 日志记录级别
        'level' => ['error', 'debug', \think\Env::get('log.database')],
        //MongoDB的连接配置
        'connection' => 'default',
        //默认日志数据库名称
        'database' => 'log',
        //日志时间日期格式
        'time_format' => "Y-m-d H:i:s",
        //独立记录的日志级别
        'apart_level' => [\think\Env::get('log.database')],
        // 缓存前缀
        'prefix' => '',
        // 缓存有效期 0表示永久缓存
        'expire' => 0,
    ],
    'session' => [
        'id'             => '',
        'var_session_id' => '',
        'prefix'         => 'think',
        'type'           => '',
        'auto_start'     => true,
        'httponly'       => true,
        'secure'         => false,
        'path'           => RUNTIME_PATH . 'session'
    ],

    'template' => [
        // 模板引擎类型 支持 php think 支持扩展
        'type' => 'Think',
        // 模板路径
        'view_path' => ROOT_PATH . 'themes/',
        // 模板后缀
        'view_suffix' => 'html',
        // 模板文件名分隔符
        'view_depr' => DS,
        // 模板引擎普通标签开始标记
        'tpl_begin' => '{',
        // 模板引擎普通标签结束标记
        'tpl_end' => '}',
        // 标签库标签开始标记
        'taglib_begin' => '{',
        // 标签库标签结束标记
        'taglib_end' => '}',
    ],
];