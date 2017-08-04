<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/18 11:23
 */
return [
    // 服务器地址
    'hostname'        => \think\Env::get("mysql.hostname",'127.0.0.1'),
    // 数据库名
    'database'        => \think\Env::get("mysql.database",'api'),
    // 用户名
    'username'        => \think\Env::get("mysql.username",'root'),
    // 密码
    'password'        => \think\Env::get("mysql.password",'root'),
    // 端口
    'hostport'        => \think\Env::get("mysql.hostport",'3306'),
    // 数据库表前缀
    'prefix'          => \think\Env::get("mysql.prefix",'api_'),
];