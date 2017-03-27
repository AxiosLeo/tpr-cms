<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/3/27 10:16
 */
return [
    'cluster' => false,

    'default' => [
        'host'          => \think\Env::get("redis.host"),
        'auth'          => \think\Env::get("redis.auth"),
        'port'          => \think\Env::get("redis.port"),
        'prefix'        => \think\Env::get("redis.prefix"),
        'database'      =>[
            'default'    => 0,
        ]
    ],
    'api_redis'=>[
        'host'          => \think\Env::get("redis.host"),
        'auth'          => \think\Env::get("redis.auth"),
        'port'          => \think\Env::get("redis.port"),
        'prefix'        => \think\Env::get("redis.prefix"),
        'database'      =>[
            'default'    => 0,
        ]
    ]
];