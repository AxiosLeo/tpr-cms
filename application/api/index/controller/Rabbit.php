<?php
/**
 * @author  : Axios
 * @email   : axioscros@aliyun.com
 * @blog    :  http://hanxv.cn
 * @datetime: 2017/9/1 17:12
 */

namespace tpr\api\index\controller;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use library\controller\BaseController;

class Rabbit extends BaseController
{
    public function send()
    {
        /**
         * 连接RabbitMq-Server
         */
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');

        //选择channel
        $channel = $connection->channel();

        //选择队列,队列名: 'hello'
        $queue_name = 'hello';
        $channel->queue_declare($queue_name, false, false, false, false);

        // 连续20次发送
        for ($i = 0; $i < 20; $i++) {
            $msg = new AMQPMessage('Hello World!' . time() . '->count:' . $i);
            $channel->basic_publish($msg, '', $queue_name);
        }

        $channel->close();
        $connection->close();
        $this->response($queue_name);
    }

    public function receive()
    {
        //接收者名称
        $receiver_name = uniqid();

        //使用Fork类异步执行消息接收
        $this->response($receiver_name);
    }

    public function forkReceive($receive_name)
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');

        //选择channel
        $channel = $connection->channel();

        //选择队列,队列名: 'hello'
        $channel->queue_declare('hello', false, false, false, false);
        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
        $callback = function ($msg) use ($receive_name) {
            echo " [x] Received ", $msg->body, "\n";
        };

        //监听队列
        $channel->basic_consume('hello', '', false, true, false, false, $callback);
        while (count($channel->callbacks)) {
            $channel->wait();
        }
        $channel->close();
        $connection->close();
    }
}