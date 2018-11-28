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
class Mysql extends MysqlFacade
{
    public static function __callStatic($method, $params)
    {
        $Con = Connector::newCon('mysql.default', 'mysql.default');
        return call_user_func_array([$Con, $method], $params);
    }
}