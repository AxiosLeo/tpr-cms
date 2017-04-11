<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/11 14:41
 */
namespace app\common\service;
use think\Config;
use \Redis;
class RedisService extends Redis {
    private $config;
    private $prefix;
    private $db;
    public function __construct($select = 'default')
    {
        $this->config = Config::get('redis');
        $this->connection($select);
    }
    public static function redis($select= 'default'){
        return new self($select);
    }
    public function connection($select = 'default'){
        if(array_key_exists($select,$this->config)){
            return $this->do_connect($this->config[$select]);
        }else{
            return 'config error';
        }
    }

    /**
     * @desc 进行redis连接
     * @param $config
     * @return mixed
     */
    private function do_connect($config){
        $this->config = $config;
        if(isset($config['type']) && $config['type'] == 'unix'){
            if (!isset($config['socket'])) {
                return 'redis config key [socket] not found';
            }
            $this->connect($config['socket']);
        }else{
            $port = isset($config['port']) ? intval($config['port']) : 6379;
            $timeout = isset($config['timeout']) ? intval($config['timeout']) : 300;
            $this->connect($config['host'], $port, $timeout);
        }

        if(isset($config['auth']) && !empty($config['auth'])){
            $this->auth($config['auth']);
        }

        $this->db = isset($config['database']) ? intval($config['database']) : 0;
        $this->select($this->db);
        $this->prefix = isset($config['prefix'])&& !empty($config['prefix']) ? $config['prefix'] : 'default:';
        $this->setOption(\Redis::OPT_PREFIX, $this->prefix );
        return $this;
    }

    /**
     * 切换数据库
     * @param $name
     * @return $this
     */
    public function switchDB($name){
        $arr = $this->config['database'];
        if(is_int($name)){
            $db = $name;
        }else{
            $db = isset($arr[$name]) ? $arr[$name] : 0;
        }
        if($db != $this->db){
            $this->select($db);
            $this->db = $db;
        }
        return $this;
    }

    /************************************  Some little tools  ************************************/

    /**
     * counter
     * @desc 创建计数器
     * @param $key
     * @param int $init
     * @param int $expire
     * @return int
     */
    public function counter($key,$init=0,$expire=0){
        if(empty($expire)){
            $this->set($key,$init);
        }else{
            $this->psetex($key,$expire,$init);
        }
        return $init;
    }
    public function countNumber($key){
        if(!$this->exists($key)){
            return false;
        }
        return $this->get($key);
    }

    /**
     * @desc 进行计数
     * @param $key
     * @return bool|int
     */
    public function count($key){
        if(!$this->exists($key)){
            return false;
        }
        $count = $this->incr($key);
        return $count;
    }

    public function setsMembers($key){
        $size = $this->sCard($key);
        $members = [];
        for($i=0;$i<$size;$i++){
            $members[$i] = $this->sPop($key);
        }
        foreach ($members as $m){
            $this->sAdd($key,$m);
        }
        return $members;
    }

    function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->close();
    }
}