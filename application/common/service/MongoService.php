<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/10 16:11
 */
namespace app\common\service;
use think\Config;
use think\mongo\Connection;
class MongoService extends Connection{
    function __construct(array $config = [])
    {
        if(empty($config)){
            $config = Config::get('mongo');
        }
        parent::__construct($config);
    }
}