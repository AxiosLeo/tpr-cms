<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/8/1 下午5:06
 */

namespace library\service;

use tpr\framework\Config;

/**
 * Class RedisService
 * @package library\service
 * @desc install: https://hanxv.cn/archives/25.html#redis
 */
class RedisService extends \Redis
{
    private $config = [
        'host'     => '127.0.0.1',
        'auth'     => '',
        'port'     => '6379',
        'prefix'   => 'redis:',
        'timeout'  => 60,
        'database' => [
            'default' => 0,
        ]
    ];

    private static $config_index = '';

    private static $instance;

    private $db = 0;

    public $prefix = '';

    public function __construct($select = 'default')
    {
        self::$config_index = $select;

        $config       = Config::get('redis.' . $select);
        $config       = empty($config) ? [] : $config;
        $this->config = array_merge($this->config, $config);

        $this->do_connect($this->config);
    }

    public static function redis($select = 'default')
    {
        if (self::$instance == null) {
            self::$instance = new self($select);
        } else if (self::$config_index != $select) {
            self::$instance = new self($select);
        }
        return self::$instance;
    }

    /**
     * @desc 进行redis连接
     * @param $config
     * @return string
     */
    private function do_connect($config)
    {
        if (isset($config['type']) && $config['type'] == 'unix') {
            if (!isset($config['socket'])) {
                return 'redis config key [socket] not found';
            }
            $this->connect($config['socket']);
        } else {
            $port    = intval($config['port']);
            $timeout = intval($config['timeout']);
            $this->connect($config['host'], $port, $timeout);
        }

        if (isset($config['auth']) && !empty($config['auth'])) {
            $this->auth($config['auth']);
        }

        $this->select($this->db);

        $this->setOption(\Redis::OPT_PREFIX, $config['prefix']);
        return $this;
    }

    /**
     * 切换数据库
     * @param $dbName
     * @return $this
     */
    public function switchDB($dbName = 0)
    {
        $arr = $this->config['database'];
        if (is_int($dbName)) {
            $db = $dbName;
        } else {
            $db = isset($arr[$dbName]) ? $arr[$dbName] : 0;
        }
        if ($db != $this->db) {
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
    public function counter($key, $init = 0, $expire = 0)
    {
        if (empty($expire)) {
            $this->set($key, $init);
        } else {
            $this->psetex($key, $expire, $init);
        }
        return $init;
    }

    public function countNumber($key)
    {
        if (!$this->exists($key)) {
            return false;
        }
        return $this->get($key);
    }

    /**
     * @desc 进行计数
     * @param $key
     * @return bool|int
     */
    public function count($key)
    {
        if (!$this->exists($key)) {
            return false;
        }
        $count = $this->incr($key);
        return $count;
    }

    public function setsMembers($key)
    {
        $size    = $this->sCard($key);
        $members = [];
        for ($i = 0; $i < $size; $i++) {
            $members[$i] = $this->sPop($key);
        }
        foreach ($members as $m) {
            $this->sAdd($key, $m);
        }
        return $members;
    }


    public function setArray($key, $array, $ttl = 0)
    {
        if ($ttl) {
            return $this->set($key, $this->formatArray($array), ['ex' => $ttl]);
        } else {
            return $this->set($key, $this->formatArray($array));
        }
    }

    public function getArray($key)
    {
        if (!$this->exists($key)) {
            return false;
        }
        return $this->unFormatArray($this->get($key));
    }

    private function formatArray($array)
    {
        return base64_encode(@serialize($array));
    }

    private function unFormatArray($data)
    {
        return @unserialize(base64_decode($data));
    }

    function __destruct()
    {
        $this->close();
    }
}