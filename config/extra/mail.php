<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/16 11:02
 */
return [
    'default'=>[
        'is_smtp'    =>true,
        'host'       =>'smtp.qq.com',
        'port'       =>465,
        'smtp_auth'  =>true,
        'username'   =>'',
        'password'   =>'',
        'email'      =>'',
        'from_name'  =>'',
        'smtp_secure'=>'ssl',
        'char_set'   =>'UTF-8'
    ],
    'code_email'=>[
        'is_smtp'    =>true,
        'host'       =>'',
        'port'       =>465,
        'smtp_auth'  =>true,
        'username'   =>'',
        'password'   =>'',
        'email'      =>'',
        'from_name'  =>'',
        'smtp_secure'=>'ssl',
        'char_set'   =>'UTF-8'
    ]
];