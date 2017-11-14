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
use think\Response;
use think\Tool;
use Workerman\Connection\ConnectionInterface;
use Workerman\Connection\TcpConnection;
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

    /**
     * @var TcpConnection
     */
    public static $connector ;

    protected $return_type;

    protected static $config = [
        'server' => "websocket://0.0.0.0:2346",
        'process_count' => 4 ,
        'ssl'=>false,
        'context'=>[]
    ];

    /**
     * 启动workman
     * @param array $config
     */
    public static function run($config = [])
    {
        self::init();

        self::$config = array_merge(self::$config , $config);

        $server = self::$config['server'];

        $context = self::$config['context'];

        $ssl = self::$config['ssl'];

        $process_count = self::$config['process_count'];

        self::$worker = new Worker($server,$context);

        if($ssl){
            self::$worker->transport = 'ssl';
        }

        self::$worker->count = $process_count;

        self::$worker->onWorkerStart = function($task)
        {
            Workman::task($task);
        };

        self::$worker->onConnect = function ($connection) {
            Workman::connect($connection);
        };

        self::$worker->onMessage = function($connection, $data)
        {
            Workman::receive($connection , $data);

        };

        self::$worker->onClose = function($connection)
        {
            self::$connector = $connection;
            return self::response('success close');
        };

        Worker::runAll();

    }

    /**
     * @param $connection
     * @param $data
     * @return bool|null
     */
    public static function receive($connection , $data){
        self::$connector = $connection;
        $data = self::data($data);
        return self::result($data);
    }

    /**
     * @param Worker $task
     */
    public static function task(Worker $task){

    }

    /**
     * @param TcpConnection $connection
     */
    public static function connect($connection){
        self::$connector = $connection;

        self::response('connect success');
    }

    /**
     * close connection
     * @param ConnectionInterface $connection
     */
    public static function close($connection){
        $connection->close();
    }



    protected static function result($result = [], array $header = [])
    {
        $result = Tool::checkData2String($result);
        if(isset($result['time'])){
            $result['time'] = time();
        }
        $type = c('default_ajax_return', 'json');
        $data = Response::create($result, $type)->header($header)->getContent();
        return self::$connector->send($data);
    }
}