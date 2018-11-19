<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018/11/16 13:44
 */

namespace library\connector\redis;

class KV
{
    /**
     * @param \Redis|\RedisCluster $redis
     * @param string               $key
     *
     * @return self
     */
    public static function key($key, $redis = null)
    {
        return new self($key, $redis);
    }

    /**
     * @var \Redis|\RedisCluster
     */
    private $redis;

    private $key;

    public function __construct($key, $redis)
    {
        $this->key   = $key;
        $this->redis = $redis;
    }

    public function set($value, $timeout = 0)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        return $this->redis->set($this->key, $value, $timeout);
    }

    public function get()
    {
        $data = $this->redis->get($this->key);
        $tmp  = @json_decode($data, true);
        if (is_array($tmp)) {
            $data = $tmp;
        }
        return $data;
    }
}