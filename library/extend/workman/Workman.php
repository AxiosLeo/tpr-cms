<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/1/25 14:59
 */
namespace library\extend\workman;

use library\extend\workman\lib\Connect;
use library\extend\workman\lib\Request;
use library\extend\workman\lib\Response;
use library\extend\workman\lib\Task;
use tpr\framework\App;
use tpr\framework\Config;
use tpr\framework\Env;
use Workerman\Worker;

class Workman
{
    protected static $workman_config = [
        'server'        => "websocket://0.0.0.0:2346",
        'workman_name'  => 'workman_server',
        'process_count' => 4 ,
        'ssl'           => false,
        'context'       => [],
        'heartbeat'     => 10
    ];

    public static $config;

    public static function run($config = []){
        self::$config = App::initCommon();

        $env = Env::get('global.env' , 'product');

        $workman_config = Config::get('workman.'.$env);
        if(!empty($workman_config)){
            self::$workman_config = array_merge(self::$workman_config , $workman_config);
        }

        if(!empty($config)){
            self::$workman_config = array_merge(self::$workman_config , $config);
        }

        WorkmanOption::setServer(self::$workman_config['server']);
        WorkmanOption::setContext(self::$workman_config['context']);
        WorkmanOption::setProcessCount(self::$workman_config['process_count']);
        WorkmanOption::setSsl(self::$workman_config['ssl']);
        WorkmanOption::setHeartbeat(self::$workman_config['heartbeat']);

        define('HEARTBEAT_TIME',WorkmanOption::getHeartbeat());

        $worker = new Worker(WorkmanOption::getServer(),WorkmanOption::getContext());
        WorkmanOption::setWorker($worker);

        if(WorkmanOption::getSsl()){
            WorkmanOption::getWorker()->transport = 'ssl';
        }

        WorkmanOption::getWorker()->count = WorkmanOption::getProcessCount();

        self::server();

        Worker::runAll();
    }

    private static function server(){

        WorkmanOption::getWorker()->name = self::$workman_config['workman_name'];

        WorkmanOption::getWorker()->onWorkerStart = function($worker)
        {
            Task::run($worker);
        };

        WorkmanOption::getWorker()->onWorkerReload = false;

        WorkmanOption::getWorker()->onConnect = function ($connection) {
            Connect::run($connection);
        };

        WorkmanOption::getWorker()->onMessage = function($connection, $data)
        {
            Request::run($connection , $data);
        };

        WorkmanOption::getWorker()->onClose = function($connection)
        {
            Connect::close($connection);
        };

        WorkmanOption::getWorker()->onBufferFull = function($connection)
        {
            $data = Response::wrong(101,'bufferFull and do not send again');
            Response::send($connection, $data);
        };

        WorkmanOption::getWorker()->onBufferDrain = function($connection)
        {
            $data = Response::wrong(102,'buffer drain and continue send');
            Response::send($connection, $data);
        };


        WorkmanOption::getWorker()->onError = function($connection, $code, $msg)
        {
            $data = Response::wrong($code,$msg);
            Response::send($connection, $data);
        };
    }
}