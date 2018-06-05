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
        'host'          => \tpr\framework\Env::get("redis.host",'127.0.0.1'),
        'auth'          => \tpr\framework\Env::get("redis.password",null),
        'port'          => \tpr\framework\Env::get("redis.port",'6379'),
        'prefix'        => \tpr\framework\Env::get("redis.prefix",'api:'),
        'database'      =>[
            'default_db'    => 0,
            'users_token'   => 1,
            'message_code'  => 2,
            'counter'       => 3
        ]
    ],
];