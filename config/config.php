<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 10:28
 */

/**
 * Config Example : https://github.com/AxiosCros/tpr-framework/blob/master/convention.php
 */
return [
    // 应用调试模式
    'app_debug' => \tpr\framework\Env::get('global.debug',true),

    'log' => [
        // 日志记录方式，内置 file socket 支持扩展
        'type' => 'File',
        // 日志保存目录
        'path' => LOG_PATH,
        // 日志记录级别
        'level' => ['error', 'debug','info'],
        //MongoDB的连接配置
        'connection' => 'default',
        //默认日志数据库名称
        'database' => 'log',
        //日志时间日期格式
        'time_format' => "Y-m-d H:i:s",
        //独立记录的日志级别
        'apart_level' => [],
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
];