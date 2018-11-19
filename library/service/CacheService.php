<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018/11/19 15:56
 */

namespace library\service;

use library\connector\RedisClient;

class CacheService
{
    public static function set($key, $value, $timeout = 3600)
    {
        return RedisClient::init("redis.cache")->kv($key)->set($value, $timeout);
    }

    public static function get($key)
    {
        $exist = RedisClient::init("redis.cache")->redis()->exists($key);
        if ($exist) {
            return RedisClient::init("redis.cache")->kv($key)->get();
        }
        return null;
    }
}