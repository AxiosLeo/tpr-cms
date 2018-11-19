<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018/11/16 13:13
 */

namespace library\connector;

use library\connector\redis\KV;
use tpr\framework\Config;
use \Redis;
use \RedisCluster;

class RedisClient
{
    private static $defaultConfig = [
        "single"  => [
            'host'     => '127.0.0.1',
            'auth'     => '',
            'port'     => '6379',
            'prefix'   => 'redis:',
            'timeout'  => 60,
            'database' => [
                'default' => 0,
            ]
        ],
        "cluster" => [
            "cluster_name" => null,
            "hosts"        => [
                "127.0.0.1:6379"
            ],
            'auth'         => '',
            'prefix'       => 'redis:',
            'timeout'      => 1.5,
            'read_timeout' => 1.5,
            'persistent'   => true,
            'database'     => [
                'default' => 0,
            ]
        ]
    ];

    private static $instance = [];

    /**
     * @param string $config_index
     *
     * @return self
     */
    public static function init($config_index = "")
    {
        if (empty($config_index)) {
            $config_index = "default";
        }
        if (isset(self::$instance[$config_index])) {
            return self::$instance[$config_index];
        }
        $config = Config::get($config_index);
        $hosts  = data($config, "hosts", []);

        $is_cluster = !empty($hosts);

        $default_config = $is_cluster ? self::$defaultConfig["cluster"] : self::$defaultConfig["single"];

        $config = array_merge($default_config, $config);

        self::$instance[$config_index] = self::instance($config);

        return self::$instance[$config_index];
    }

    public static function clear($config_index = null)
    {
        if (is_null($config_index)) {
            self::$instance = [];
        } else if (isset(self::$instance[$config_index])) {
            unset(self::$instance[$config_index]);
        }
    }

    /**
     * @param array $config
     *
     * @return RedisClient
     */
    public static function instance($config = [])
    {
        return new self($config);
    }

    /**
     * @var Redis|RedisCluster
     */
    private $redis;

    private $config;

    public function __construct($config = [])
    {
        $this->config = $config;
        $is_cluster   = data($this->config, "cluster", false);
        if ($is_cluster) {
            $this->redis = new RedisCluster(
                $config["cluster_name"],
                $config["seeds"],
                $config["timeout"],
                $config["read_timeout"],
                $config["persistent"]
            );
        } else {
            $this->redis = new Redis();
            $this->redis->connect(
                $config['host'],
                $config["port"],
                $config["timeout"]
            );
        }

        if (!empty($config["auth"])) {
            $this->redis->auth($config["auth"]);
        }
        $this->redis->setOption(Redis::OPT_PREFIX, $config['prefix']);
    }

    public function redis()
    {
        return $this->redis;
    }

    public function kv($key)
    {
        return KV::key($key, $this->redis);
    }
}