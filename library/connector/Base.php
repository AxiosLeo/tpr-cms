<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/10/23 14:38
 */

namespace library\connector;

use tpr\db\Db;
use tpr\framework\Config;

/**
 * Trait Common
 * @package library\connector
 */
trait Base
{
    /**
     * @param $name
     * @return \tpr\db\core\Query
     */
    public static function name($name)
    {
        $db = Db::model(self::$connect);
        if (is_null($db)) {
            $config = Config::get(self::$connect);
            $db = Db::connect($config, self::$connect);
        }
        return $db->name($name);
    }

    /**
     * @param $table
     * @return \tpr\db\core\Query
     */
    public static function table($table)
    {
        $db = Db::model(self::$connect);
        if (is_null($db)) {
            $config = Config::get(self::$connect);
            $db = Db::connect($config, self::$connect);
        }
        return $db->table($table);
    }

}