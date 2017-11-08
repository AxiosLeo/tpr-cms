<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/11/8 09:39
 */

namespace server\lib;

use PhpAmqpLib\Connection\AMQPSocketConnection;
use server\traits\Jump;
use think\Tool;

class Rabbitmq
{
    use Jump;

    protected static $rabbit_config = [
        'host'    => 'localhost',
        'port'    => 5672,
        'user'    => 'guest',
        'password'=> 'guest'
    ];

    protected static $queue_config = [
        'name'       => 'queue',
        'passive'    => false,
        'durable'    => false,
        'exclusive'  => false,
        'auto_delete'=> true,
    ];

    protected static $consume_config = [
        'consumer_tag' => '',
        'no_local'     => false,
        'no_ack'       => true,
        'exclusive'    => false,
        'nowait'       => false
    ];

    public static function run($rabbit_config = [] , $channel_id = null , $queue_config = [] , $consume_config = [], $callback = null){
        self::init();

        self::$rabbit_config = array_merge(self::$rabbit_config , $rabbit_config);
        self::$queue_config = array_merge(self::$queue_config , $queue_config);
        self::$consume_config = array_merge(self::$consume_config , $consume_config);

        $connection = new AMQPSocketConnection(
            self::$rabbit_config['host'],
            self::$rabbit_config['port'],
            self::$rabbit_config['user'],
            self::$rabbit_config['password']);

        //选择channel
        $channel = $connection->channel($channel_id);

        //选择队列,队列名: 'hello'
        $channel->queue_declare(
            self::$queue_config['name'],
            self::$queue_config['passive'],
            self::$queue_config['durable'],
            self::$queue_config['exclusive'],
            self::$queue_config['auto_delete']
        );

        $receive_name = Tool::uuid();
        if(is_null($callback) || !($callback instanceof \Closure)){
            $callback = function($msg) use ($receive_name) {
                echo " [$receive_name] Received ", $msg->body, "\n";
                self::data($msg->boday);
            };
        }

        //监听队列
        $channel->basic_consume(
            self::$queue_config['name'],
            self::$consume_config['consumer_tag'],
            self::$consume_config['no_local'],
            self::$consume_config['no_ack'],
            self::$consume_config['exclusive'],
            self::$consume_config['nowait'],
            $callback
        );
        while(count($channel->callbacks)) {
            $channel->wait();
        }
        $channel->close();
        $connection->close();
    }
}