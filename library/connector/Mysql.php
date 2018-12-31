<?php
/**
 * @author  : Axios
 * @email   : axioscros@aliyun.com
 * @blog    :  http://hanxv.cn
 * @datetime: 2017/10/23 10:59
 */

namespace library\connector;

use tpr\db\DbClient;
use tpr\db\DbFacade;
use tpr\framework\Config;

/**
 * Class Example
 * @package library\connector
 * @example Mysql::name($name)
 */
class Mysql extends DbFacade
{
    private static $instance;

    public static function __callStatic($method, $params)
    {
        if (is_null(self::$instance)) {
            $config         = Config::get('mysql.default');
            self::$instance = DbClient::newCon('mysql.default', $config);
        }
        return call_user_func_array([self::$instance, $method], $params);
    }
}