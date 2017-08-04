<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/16 11:02
 */
return [
    'cluster' => false,

    'default' => [
        'host'          => \think\Env::get("redis.host",'127.0.0.1'),
        'auth'          => \think\Env::get("redis.password",null),
        'port'          => \think\Env::get("redis.port",'6379'),
        'prefix'        => \think\Env::get("redis.prefix",'api:'),
        'database'      =>[
            'default_db'    => 0,
            'users_token'   => 1,
            'message_code'  => 2,
            'counter'       => 3
        ]
    ],
];