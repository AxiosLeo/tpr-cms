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
use tpr\db\exception\InvalidArgumentException;
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
        try{
            $db = Db::model(self::$connect)->name($name);
        }catch (InvalidArgumentException $e){
            $config = Config::get(self::$connect);
            $db = Db::connect($config,self::$connect)->name($name);
        }
        return $db;
    }

    /**
     * @param $table
     * @return \tpr\db\core\Query
     */
    public static function table($table)
    {
        try{
            $db = Db::model(self::$connect)->table($table);
        }catch (InvalidArgumentException $e){
            $config = Config::get(self::$connect);
            $db = Db::connect($config,self::$connect)->table($table);
        }
        return $db;
    }

}