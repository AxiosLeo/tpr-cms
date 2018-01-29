<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/1/25 15:05
 */

namespace library\extend\workman;


use Workerman\Worker;

class WorkmanOption
{
    public static $server;

    public static $context;

    public static $ssl;

    public static $process_count;

    public static $heartbeat;

    public static $worker;

    /**
     * @param Worker $worker
     */
    public static function setWorker(Worker $worker)
    {
        self::$worker = $worker;
    }

    /**
     * @return Worker mixed
     */
    public static function getWorker()
    {
        return self::$worker;
    }

    /**
     * @param mixed $context
     */
    public static function setContext($context)
    {
        self::$context = $context;
    }

    /**
     * @param mixed $heartbeat
     */
    public static function setHeartbeat($heartbeat)
    {
        self::$heartbeat = $heartbeat;
    }

    /**
     * @param mixed $process_count
     */
    public static function setProcessCount($process_count)
    {
        self::$process_count = $process_count;
    }

    /**
     * @param mixed $server
     */
    public static function setServer($server)
    {
        self::$server = $server;
    }

    /**
     * @param mixed $ssl
     */
    public static function setSsl($ssl)
    {
        self::$ssl = $ssl;
    }

    /**
     * @return mixed
     */
    public static function getContext()
    {
        return self::$context;
    }

    /**
     * @return mixed
     */
    public static function getHeartbeat()
    {
        return self::$heartbeat;
    }

    /**
     * @return mixed
     */
    public static function getProcessCount()
    {
        return self::$process_count;
    }

    /**
     * @return mixed
     */
    public static function getServer()
    {
        return self::$server;
    }

    /**
     * @return mixed
     */
    public static function getSsl()
    {
        return self::$ssl;
    }
}