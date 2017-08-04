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
        "hostname"          => \think\Env::get('mongo.hostname','127.0.0.1'),
        "database"          => \think\Env::get('mongo.database','test'),
        "username"          => \think\Env::get('mongo.username','test'),
        "password"          => \think\Env::get('mongo.password','123456'),
        "hostport"          => \think\Env::get('mongo.hostport','27017'),
        "dsn"               => \think\Env::get('mongo.dsn',''),
    ]
];