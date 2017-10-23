<?php

/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/10/23 10:42
 */

namespace library\connector;

use think\Db;

abstract class Common
{
    protected static $connect = "default";

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