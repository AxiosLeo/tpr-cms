<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/2 14:06
 */
return [
    'sign'=>[
        'timestamp_name'=>"timestamp",
        'sign_mame'=>'sign',
        'sign_expire'=>10000
    ],
    'token'=>[
        'token_expire'=>86400
    ],
    'admin'=>[
        'themes'=>"default"
    ],
    'api_log'=>[
        'status'=>\think\Env::get('log.status'),
        'log_database'=>'tpr_log'
    ]
];