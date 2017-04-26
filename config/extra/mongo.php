<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/10 16:12
 */
return [
    'default'=>[
        "type"              => '\think\mongo\Connection',
        "hostname"          => \think\Env::get('mongo.hostname'),
        "database"          => \think\Env::get('mongo.database'),
        "username"          => \think\Env::get('mongo.username'),
        "password"          => \think\Env::get('mongo.password'),
        "hostport"          => \think\Env::get('mongo.hostport'),
        "dsn"               => \think\Env::get('mongo.dsn'),
        "params"            => [],
        "charset"           => "utf8",
        "pk"                => "_id",
        "pk_type"           => "ObjectID",
        "prefix"            => "",
        "debug"             => false,
        "deploy"            => 0,
        "rw_separate"       => false,
        "master_num"        => 1,
        "slave_no"          => "",
        "fields_strict"     => true,
        "resultset_type"    => "array",
        "auto_timestamp"    => false,
        "datetime_format"   => "Y-m-d H:i:s",
        "sql_explain"       => false,
        "pk_convert_id"     => false,
        "type_map" => [
            "root" =>"array",
            "document"=>"array",
            "query" =>"\\think\\mongo\\Query"
        ]
    ]
];