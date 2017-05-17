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
        'host'          => \think\Env::get("redis.host"),
        'auth'          => \think\Env::get("redis.password"),
        'port'          => \think\Env::get("redis.port"),
        'prefix'        => \think\Env::get("redis.prefix"),
        'database'      =>[
            'default_db'    => 0,
            'users_token'   => 1,
            'message_code'  => 2,
            'counter'       => 3
        ]
    ],
];