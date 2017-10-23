<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/10/23 10:59
 */

namespace library\connector;
use think\Db;

/**
 * Class Example
 * @package library\connector
 * @example Example::name($name) ; Example::name($name)
 */
class Example
{
    protected static $connect = "mysql.example";  // config in "CONF_PATH/extra/mysql.php"  and config name is "example"

    /**
     * @param $name
     * @return \think\db\Query
     */
    public static function name($name){
        return Db::model(self::$connect . $name , self::$connect )->name($name);
    }

    /**
     * @param $table
     * @return \think\db\Query
     */
    public static function table($table)
    {
        return Db::model(self::$connect . $table, self::$connect)->table($table);
    }
}