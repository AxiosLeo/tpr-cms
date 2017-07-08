<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/16 11:10
 */
return [
    'default'=>[
        // 服务器地址
        'hostname'        => \think\Env::get("mysql.hostname"),
        // 数据库名
        'database'        => \think\Env::get("mysql.database"),
        // 用户名
        'username'        => \think\Env::get("mysql.username"),
        // 密码
        'password'        => \think\Env::get("mysql.password"),
        // 端口
        'hostport'        => \think\Env::get("mysql.hostport"),
    ]
];