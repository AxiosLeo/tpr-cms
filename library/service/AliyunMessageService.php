<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 04/01/2018 17:06
 */

namespace library\service;

namespace library\service;

use PFinal\Aliyun\AliyunSMS;
use think\Config;

class AliyunMessageService
{
    public static $instance;

    public static $config_index = 'app.aliyun_message';

    public static $config = [
        'accessKeyId'=>'',
        'accessSecret'=>'',
        'signName'=>'',
        'templateCode'=>[

        ]
    ];

    /**
     * @var AliyunSMS $sms
     */
    private static $sms;

    private static $template = [];

    public static function instance($config_index = 'app.aliyun_message'){
        date_default_timezone_set('PRC');
        if(is_null(self::$instance)){
            self::$instance = new self();
        }

        if(self::$config_index != $config_index){
            self::$config_index = $config_index;
        }

        self::$config = array_merge(self::$config , Config::get($config_index));

        self::$sms =  new AliyunSMS();
        self::$sms->accessKeyId = self::$config['accessKeyId'];
        self::$sms->accessKeySecret = self::$config['accessSecret'];
        self::$sms->signName = self::$config['signName'];

        self::$template = self::$config['templateCode'];

        return self::$instance;
    }

    public function sendCode($mobile,$code,$code_key='name',$template='code'){
        if(isset(self::$template[$template])){
            self::$sms->templateCodeKey = $code_key;
            self::$sms->templateId = self::$template[$template];
            return self::$sms->sendCode($mobile,$code);
        }
        return false;
    }

    public function sendMessage($mobile,$template,$param = []){
        if(isset(self::$template[$template])){
            self::$sms->templateId = self::$template[$template];
            return self::$sms->templateSMS($mobile,self::$template[$template],$param);
        }
        return false;
    }
}