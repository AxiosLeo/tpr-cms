<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/10/26 上午9:51
 */

namespace library\service;


class GearmanService
{
    /**
     * @var GearmanService
     */
    protected static $instance ;

    protected static $config = [
        "servers" => "127.0.0.1:4730"
    ];

    public static function instance($config = []){
        if(is_null(self::$instance)){
            self::$instance = new static();
        }

        if(is_array($config)){
            self::$config = array_merge(self::$config , $config);
        }else if(is_string($config)){
            $config = c('gearman.'.$config , self::$config);
            self::$config = array_merge(self::$config , $config);
        }

        return self::$instance;
    }
    public function task($data , $job = 'job'){
        $gmc= new \GearmanClient();

        $gmc->addServers(self::$config['servers']);
        $gmc->addTaskBackground($job, json_encode($data), null);
        $gmc->runTasks();

        return true;
    }
}