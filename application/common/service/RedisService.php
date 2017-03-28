<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/3/28 16:26
 */
namespace app\common\service;
use think\Config;
class RedisService extends \Redis {
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

    public function makeToken($user_id){
        $this->switchDB("users_token");
        $key = "hailun-system-user-".$user_id;
        $uniq = uniqid();
        $this->set($key,md5($uniq));
    }

    public function getToken($user_id){
        $this->switchDB("users_token");
        $key = "hailun-system-user-".$user_id;
        return $this->get($key);
    }

    public function makeSystemCheckCode($code,$time=180){
        $this->switchDB(0);
        $this->del("hl_check_code");
        $this->setex("hl_check_code",$time,$code);
    }
    public function getSystemCheckCode(){
        $this->switchDB(0);
        return $this->get("hl_check_code");
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

    public function log($user_id,$route,$name ,$param ){
        $this->switchDB(3);
        list($module,$class,$function) = explode("/",$route);
        $data = [
            'route'=>$route,
            'module'=>$module,
            'class'=>$class,
            'func'=>$function,
            'name'=>$name,
            'param'=>$param,
            'timestamp'=>time(),
            'datetime'=>date("Y-m-d H:i:s")
        ];
        $log_key = "log_".$user_id."_".uniqid();
        $this->hSet("logger_".$user_id,$log_key,serialize($data));
        return $this->hGet("logger_".$user_id,$log_key);
    }
    public function viewLog($user_id){
        $this->switchDB(3);
        $log_key = "logger_".$user_id;
        $convert_log = [];
        $logs = $this->hGetAll($log_key);
        foreach ($logs as $k=>$v){
            $temp = unserialize($v);
            $convert_log[$k] = $temp;
        }
        return $convert_log;
    }
    public function delLog($user_id){
        $this->switchDB(3);
        return $this->del("logger_".$user_id);
    }

    function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->close();
    }
}