<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/16 11:02
 */
return [
    "default"=>[
        "hostname"          => \think\Env::get('mongo.hostname'),
        "database"          => \think\Env::get('mongo.database'),
        "username"          => \think\Env::get('mongo.username'),
        "password"          => \think\Env::get('mongo.password'),
        "hostport"          => \think\Env::get('mongo.hostport'),
        "dsn"               => \think\Env::get('mongo.dsn'),
    ]
];