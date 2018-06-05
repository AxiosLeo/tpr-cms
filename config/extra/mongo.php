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
        "type"              => '\\tpr\\db\\connector\\MongoConnection',
        "hostname"          => \tpr\framework\Env::get('mongo.hostname','127.0.0.1'),
        "database"          => \tpr\framework\Env::get('mongo.database','test'),
        "username"          => \tpr\framework\Env::get('mongo.username','test'),
        "password"          => \tpr\framework\Env::get('mongo.password','123456'),
        "hostport"          => \tpr\framework\Env::get('mongo.hostport','27017'),
        "dsn"               => \tpr\framework\Env::get('mongo.dsn',''),
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
        "pk_convert_id"     => true,
        "type_map" => [
            "root" =>"array",
            "document"=>"array",
            "query" =>"\\tpr\\db\\query\\MongoQuery"
        ]
    ]
];