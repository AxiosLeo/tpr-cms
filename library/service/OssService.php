<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/7/26 13:33
 */
namespace library\service;

use Aliyun\OSS\Exceptions\OSSException;
use JohnLui\AliyunOSS;
use think\Config;

class OssService{

    /**
     * @var AliyunOSS
     */
    public static $oss;

    protected static $config = [
        'city'=>'杭州',
        'network_type'=>'经典网络',
        'is_internal'=>'',
        'access_key_id'=>'',
        'access_key_secret'=>'',
    ];

    public static $instance ;

    protected static $select = '';

    public function __construct($select = 'default')
    {
        self::config($select);
    }

    private static function config($select){
        $config = Config::get('oss.'.$select);
        self::$select = $select;
        $config = array_merge(self::$config,$config);

        $city         = $config['city'];
        $networkType  = $config['network_type'];
        $isInternal   = $config['is_internal'];
        $AccessKeyId  = $config['access_key_id'];
        $AccessKeySecret = $config['access_key_secret'];

        self::$oss = new AliyunOSS($city, $networkType, $isInternal, $AccessKeyId, $AccessKeySecret);
    }

    public static function oss($select = 'default'){
        if(self::$instance == null){
            self::$instance = new static($select);
        }

        if(self::$select != $select){
            self::config($select);
        }

        return self::$oss;
    }

    public static function fileExist($key = '', $bucket = '',$select = 'default')
    {
        try {
            $key = !empty($key) ? $key : 'empty';
            self::oss($select)->getObjectMeta($bucket, $key);
            return true;
        } catch (OSSException $e) {
            if ($e->getErrorCode() == 'NoSuchKey') {
                return false;
            }
        }
        return true;
    }
}