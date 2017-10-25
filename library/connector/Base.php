<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/10/23 14:38
 */

namespace library\connector;

use think\Db;

/**
 * Trait Common
 * @package library\connector
 */
trait Base
{
    /**
     * @param $name
     * @return \think\db\Query
     */
    public static function name($name)
    {
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