<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/10/26 上午9:11
 */
namespace server\lib;

use server\traits\Jump;
use think\Config;
use think\Env;
use think\Response;
use think\Tool;
use Workerman\Connection\ConnectionInterface;
use Workerman\Connection\TcpConnection;
use Workerman\Lib\Timer;
use Workerman\Worker;

require_once __DIR__ . '/../traits/Jump.php';

/**
 * Class Workman
 * @package server\lib
 * @desc workman manual:   https://www.kancloud.cn/walkor/workerman
 */
class Workman {

    use Jump;

    public static $worker;

    protected $return_type;

    protected static $workman_config = [
        'server'        => "websocket://0.0.0.0:2346",
        'process_count' => 4 ,
        'ssl'           => false,
        'context'       => [],
        'heartbeat'     => 10
    ];

    /**
     * 启动workman
     * @param array $config
     */
    public static function run($config = [])
    {
        self::init();

        $env = Env::get('global.env' , 'product');

        $workman_config = Config::get('workman.'.$env);
        if(!empty($workman_config)){
            self::$workman_config = array_merge(self::$workman_config , $workman_config);
        }

        self::$workman_config = array_merge(self::$workman_config , $config);

        $server = self::$workman_config['server'];
        $context = self::$workman_config['context'];
        $ssl = self::$workman_config['ssl'];
        $process_count = self::$workman_config['process_count'];
        $heartbeat = self::$workman_config['heartbeat'];
        define('HEARTBEAT_TIME',$heartbeat);

        self::$worker = new Worker($server,$context);
        if($ssl){
            self::$worker->transport = 'ssl';
        }

        self::$worker->count = $process_count;

        /**
         * @param Worker $worker
         * @throws \Exception
         */
        self::$worker->onWorkerStart = function($worker)
        {
            Workman::task($worker);
        };

        self::$worker->onWorkerReload = function($worker)
        {
            $data = self::wrong(302,'worker reloading');
            /*** @var TcpConnection $connection ***/
            foreach($worker->connections as $connection)
            {
                $connection->send($data);
            }
        };

        /**
         * @param TcpConnection $connection
         */
        self::$worker->onConnect = function ($connection) {
            Workman::connect($connection);
        };

        self::$worker->onMessage = function($connection, $data)
        {
            Workman::receive($connection , $data);
        };

        /**
         * @param TcpConnection $connection
         */
        self::$worker->onClose = function($connection)
        {
            $data = self::response('success close');
            $connection->send($data);
        };

        /**
         * @param TcpConnection $connection
         */
        self::$worker->onBufferFull = function($connection)
        {
            $data = self::wrong(101,'bufferFull and do not send again');
            $connection->send($data);
        };
        /**
         * @param TcpConnection $connection
         */
        self::$worker->onBufferDrain = function($connection)
        {
            $data = self::wrong(102,'buffer drain and continue send');
            $connection->send($data);
        };

        /**
         * @param TcpConnection $connection
         * @param $code
         * @param $msg
         */
        self::$worker->onError = function($connection, $code, $msg)
        {
            $data = self::wrong($code,$msg);
            $connection->send($data);
        };

        Worker::runAll();
    }

    /**
     * @param TcpConnection $connection
     * @param $data
     */
    public static function receive($connection , $data){
        $connection->lastMessageTime = time();
        $instance = [
            'connection'=>$connection,
            'remote_ip'=>$connection->getRemoteIp(),
            'remote_port'=>$connection->getRemotePort()
        ];
        $data = self::data($data,$instance);
        if(!empty($data)){
            $connection->send($data);
        }
    }

    /**
     * @param Worker $worker
     */
    public static function task(Worker $worker){
        Timer::add(1, function()use($worker){
            defined('HEARTBEAT_TIME') or define('HEARTBEAT_TIME',10);
            $time_now = time();
            foreach($worker->connections as $connection) {
                /*** @var TcpConnection $connection ***/
                // 有可能该connection还没收到过消息，则lastMessageTime设置为当前时间
                if (empty($connection->lastMessageTime)) {
                    $connection->lastMessageTime = $time_now;
                    continue;
                }
                // 上次通讯时间间隔大于心跳间隔，则认为客户端已经下线，关闭连接
                if ($time_now - $connection->lastMessageTime > HEARTBEAT_TIME) {
                    $result = $connection->send(self::wrong(100,'timeout'));
                    if($result !== true){
                        $connection->close();
                    }else{
                        $connection->lastMessageTime = $time_now;
                    }
                }
            }
        });
    }

    /**
     * @param TcpConnection $connection
     */
    public static function connect($connection){
        $data = self::response('connect success');
        $connection->send($data);
    }

    /**
     * close connection
     * @param ConnectionInterface $connection
     */
    public static function close($connection){
        $connection->close();
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function setToAll($data){
        $connections = self::$worker->connections;
        /*** @var TcpConnection $c***/
        foreach ($connections as $c){
            $c->send(self::response($data));
        }
        return $data;
    }

    protected static function result($result = [], array $header = [])
    {
        $result = Tool::checkData2String($result);
        if(isset($result['time'])){
            $result['time'] = time();
        }
        $type = c('default_ajax_return', 'json');
        $data = Response::create($result, $type)->header($header)->getContent();
        return $data;
    }
}