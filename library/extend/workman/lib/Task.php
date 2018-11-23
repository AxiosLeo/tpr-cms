<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    :  http://hanxv.cn
 * @datetime: 2018/1/25 15:11
 */

namespace library\extend\workman\lib;

use Workerman\Lib\Timer;
use Workerman\Worker;

class Task
{
    /**
     * @param Worker $worker
     */
    public static function run(Worker $worker)
    {
        self::heartbeat($worker);
    }

    private static function heartbeat(Worker $worker)
    {
        Timer::add(1, function () use ($worker) {
            defined('HEARTBEAT_TIME') or define('HEARTBEAT_TIME', 10);
            $time_now = time();
            foreach ($worker->connections as $connection) {
                /*** @var Connection $connection ** */
                // 有可能该connection还没收到过消息，则lastMessageTime设置为当前时间
                if (empty($connection->lastMessageTime)) {
                    $connection->lastMessageTime = $time_now;
                    continue;
                }
                // 上次通讯时间间隔大于心跳间隔，则认为客户端已经下线，关闭连接
                if ($time_now - $connection->lastMessageTime > HEARTBEAT_TIME) {
                    $result = $connection->send(Response::wrong(100, 'timeout'));
                    if ($result !== true) {
                        Connect::close($connection);
                    } else {
                        $connection->lastMessageTime = $time_now;
                    }
                }
            }
        });
    }
}