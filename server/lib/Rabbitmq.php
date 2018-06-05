<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/11/8 09:39
 */

namespace server\lib;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use server\traits\Jump;
use tpr\framework\Tool;

require_once __DIR__ . '/../traits/Jump.php';

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

    protected static $receive_name = '';

    public static function run($rabbit_config = [] , $channel_id = null , $queue_config = [] , $consume_config = [], $callback = null){
        self::init();
        echo "框架初始化完成\n";

        self::$rabbit_config = array_merge(self::$rabbit_config , $rabbit_config);
        self::$queue_config = array_merge(self::$queue_config , $queue_config);
        self::$consume_config = array_merge(self::$consume_config , $consume_config);

        $connection = new AMQPStreamConnection(
            self::$rabbit_config['host'],
            self::$rabbit_config['port'],
            self::$rabbit_config['user'],
            self::$rabbit_config['password']);
        echo "连接成功\n";

        //选择channel
        $channel = $connection->channel($channel_id);
        echo "选择频道:$channel_id\n";

        //选择队列
        $channel->queue_declare(
            self::$queue_config['name'],
            self::$queue_config['passive'],
            self::$queue_config['durable'],
            self::$queue_config['exclusive'],
            self::$queue_config['auto_delete']
        );
        echo "选择队列:".self::$queue_config['name']."\n";

        $receive_name = Tool::uuid();
        self::$receive_name = $receive_name;
        if(is_null($callback) || !($callback instanceof \Closure)){
            $callback = function($msg) use ($receive_name) {
                echo " [$receive_name] Received ", $msg->body, "\n";
                $request = (string)$msg->body;
                self::response(self::data($request));
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
        echo "开始监听\n";
        while(count($channel->callbacks)) {
            $channel->wait();
        }
        $channel->close();
        $connection->close();

        echo "结束接收\n";
    }

    protected static function result($result = [],$header = [])
    {
        unset($header);
        if (isset($result['time'])) {
            $result['time'] = time();
        }

        $str =  "-----------------------------------------------------------------------------------\n\n";

        $str = $str . " [receive_name] " . self::$receive_name . "\n";

        $str = $str . dump($result,false , 'data');

        $str .= "-----------------------------------------------------------------------------------\n\n";

        echo $str;
    }
}