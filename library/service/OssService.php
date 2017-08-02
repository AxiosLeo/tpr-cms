<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/8/2 上午8:48
 */

namespace library\service;

use JohnLui\AliyunOSS;

/**
 * Class OssService
 * @package library\service
 * @composer johnlui/aliyun-oss
 */
class OssService{

    /**
     * @var AliyunOSS
     */
    public static $oss;

    protected $config = [
        'city'=>'杭州',
        'network_type'=>'经典网络',
        'is_internal'=>'',
        'access_key_id'=>'',
        'access_key_secret'=>'',
    ];

    public static $instance ;

    public static $config_index ;

    public function __construct($config_index = 'default')
    {
        self::$config_index = $config_index;

        self::config();
    }
    private function config(){

        $config = c('oss.' . self::$config_index, []);

        $config = array_merge($this->config,$config);

        $city         = $config['city'];
        $networkType  = $config['network_type'];
        $isInternal   = $config['is_internal'];
        $AccessKeyId  = $config['access_key_id'];
        $AccessKeySecret = $config['access_key_secret'];

        self::$oss = new AliyunOSS($city, $networkType, $isInternal, $AccessKeyId, $AccessKeySecret);
    }

    public static function oss($config_index = 'default'){
        if(self::$instance == null){
            self::$instance = new static($config_index);
        }

        if($config_index != self::$config_index){
            self::$config_index = $config_index ;
            self::config();
        }

        return self::$instance;
    }


    public static function bucket($bucket){
        if(self::$instance == null){
            self::$instance = new static();
        }
        self::$oss->setBucket($bucket);
        return self::$oss;
    }
}