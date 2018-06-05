<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/1/25 15:16
 */

namespace library\extend\workman\lib;

use library\extend\workman\WorkmanOption;
use library\logic\ConvertLogic;
use tpr\framework\Tool;
use Workerman\Worker;

class Connect
{
    public static $client = [];
    /**
     * @param Connection $connection
     */
    public static function run($connection){
        $data = Response::response('connect success');
        $uniq = ConvertLogic::convert(Tool::uuid('connection_id'),16,62).ConvertLogic::convert(Tool::uuid('connection_id'),16,62);
        self::$client[$uniq] = $connection;
        $connection->connection_id = $uniq;
        $connection->send($data);
    }

    /**
     * @param Connection $connection
     */
    public static function close($connection){
        unset(self::$client[$connection->connection_id]);
        $connection->close();
    }

    public static function allConnection(){
        return WorkmanOption::getWorker()->connections;
    }

    public static function count(){
        return count(WorkmanOption::getWorker()->connections);
    }

    public static function reload(){
        Worker::stopAll();
        Worker::runAll();
    }

    public static function stop(){
        Worker::stopAll();
    }

    /**
     * @param Connection $connection
     * @return mixed
     */
    public static function getConnectionId($connection){
        return $connection->connection_id;
    }

}