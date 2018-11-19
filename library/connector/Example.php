<?php
/**
 * @author  : Axios
 * @email   : axioscros@aliyun.com
 * @blog    :  http://hanxv.cn
 * @datetime: 2017/10/23 10:59
 */

namespace library\connector;

/**
 * Class Example
 * @package library\connector
 * @example Example::name($name) ; Example::name($name)
 */
class Example extends MysqlFacade
{
    public static function __callStatic($method, $params)
    {
        $Con = Mysql::newCon('mysql.example', 'mysql.example');
        return call_user_func_array([$Con, $method], $params);
    }
}