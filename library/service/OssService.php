<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/7/26 13:33
 */
namespace library\service;

use aliyun\sdk\Aliyun;
use aliyun\sdk\oss\Oss;
use OSS\Core\OssException;
use OSS\OssClient;
use tpr\framework\Config;

class OssService{
    protected static $config_index = "default" ;

    protected static $config = [
        'access_key_id'=>'',
        'access_key_secret'=>'',
        'region_id'=>''
    ];

    /**
     * @var OssClient
     */
    protected static $ossClient;

    protected static $instance;

    public function __construct($config_index)
    {
        self::config($config_index);
    }

    public static function oss($config_index = "default"){
        if(is_null(self::$instance) || self::$config_index != $config_index){
            self::$instance = new static($config_index);
        }

        return self::$instance;
    }

    protected static function config($config_index){
        $config = Config::get('oss.' . $config_index);
        $config = array_merge(self::$config,$config);

        Aliyun::auth($config['access_key_id'], $config['access_key_secret']);
        Aliyun::region($config['region_id']);

        self::$ossClient = Oss::factory();
    }

    public function client(){
        return self::$ossClient;
    }

    public function fileExist($key, $bucket){
        try{
            self::$ossClient->getObjectMeta($bucket, $key);
            return true;
        }catch (OssException $e){
            return false;
        }
    }

    public static function ossHost($config_index = "default"){
        $oss_config = config('oss.' . $config_index);
        $oss_host = data($oss_config , 'custom_host' , 'http://oss-yd-pianobridge.pianobridge.cn/');
        return $oss_host;
    }
}