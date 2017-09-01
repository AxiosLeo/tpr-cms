<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/9/1 17:12
 */

namespace tpr\api\index\controller;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use think\Controller;
use think\Debug;
use think\Fork;

class Rabbit extends Controller
{
    public function send(){
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare('hello', false, false, false, false);
        $basic_consume = 'hello';
        $msg = '';
        for ($i=0;$i<20;$i++){
            $msg = new AMQPMessage('Hello World!'.time() . '->count:' . $i);
            $channel->basic_publish($msg, '', $basic_consume);
        }

        $channel->close();
        $connection->close();
        $this->response($msg->body);
    }

    public function receive(){
        $receive_name = uniqid();
        Fork::work($this , 'forkReceive',[$receive_name]);
        $this->response($receive_name);
    }

    public function forkReceive($receive_name){
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare('hello', false, false, false, false);
        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
        $callback = function($msg) use ($receive_name) {
            Debug::save(ROOT_PATH . 'rabbitmq.log',$receive_name.' : '.$msg->body);
            echo " [x] Received ", $msg->body, "\n";
        };
        $channel->basic_consume('hello', '', false, true, false, false, $callback);
        while(count($channel->callbacks)) {
            $channel->wait();
        }
        $channel->close();
        $connection->close();
    }
}