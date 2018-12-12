<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018/11/19 15:56
 */

namespace library\service;

use tpr\db\DbRedis;

class CacheService
{
    public static function set($key, $value, $timeout = 3600)
    {
        return DbRedis::init("redis.cache")->kv($key)->set($value, $timeout);
    }

    public static function get($key)
    {
        $exist = DbRedis::init("redis.cache")->redis()->exists($key);
        if ($exist) {
            return DbRedis::init("redis.cache")->kv($key)->get();
        }
        return null;
    }
}