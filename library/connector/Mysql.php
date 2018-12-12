<?php
/**
 * @author  : Axios
 * @email   : axioscros@aliyun.com
 * @blog    :  http://hanxv.cn
 * @datetime: 2017/10/23 10:59
 */

namespace library\connector;

use think\facade\Config;
use tpr\db\DbClient;
use tpr\db\DbFacade;

/**
 * Class Example
 * @package library\connector
 * @example Mysql::name($name)
 */
class Mysql extends DbFacade
{
    public static function __callStatic($method, $params)
    {
        $config = Config::get('mysql.default');
        $Con = DbClient::newCon('mysql.default', $config);
        return call_user_func_array([$Con, $method], $params);
    }
}