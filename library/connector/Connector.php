<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/11/3 10:20
 */

namespace library\connector;

use tpr\db\Db;
use tpr\db\core\Connection;
use tpr\framework\Config;

class Connector extends MysqlFacade
{
    private static $instance = [];

    /**
     * 动态生成数据库连接
     *
     * @param  string $con_name
     * @param string  $config_index
     * @param array   $custom_config
     *
     * @return Connection
     */
    public static function newCon($con_name, $config_index = "", $custom_config = [])
    {
        $config = Config::get($config_index);
        if (!empty($custom_config)) {
            $config = array_merge($config, $custom_config);
        }
        return self::instance($con_name, $config);
    }

    /**
     * 关闭连接
     *
     * @param $con_name
     */
    public static function closeCon($con_name)
    {
        if (isset(self::$instance[$con_name])) {
            self::instance($con_name)->close();
            unset(self::$instance[$con_name]);
        }
    }

    /**
     * 实例化连接
     *
     * @param       $con_name
     * @param array $config
     *
     * @return Connection
     */
    private static function instance($con_name, $config = [])
    {
        if (!isset(self::$instance[$con_name])) {
            self::$instance[$con_name] = Db::connect($config, $con_name);
        }
        return self::$instance[$con_name];
    }
}