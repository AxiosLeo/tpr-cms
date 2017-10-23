<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/8/2 上午8:50
 */

namespace library\service;

use think\Tool;

/**
 * Class RestService
 * @desc 云通讯短信服务
 * @package library\service
 */
class RestService
{
    public static $baseUrl = 'https://appsms.cloopen.com:8883';

    public static $code;

    public static $msg;

    public static $serverIp = "";

    public static $serverPort = 0;

    public static $softVersion = "";

    public static $accountSid = "";

    public static $accountToken = "";

    public static $appId = "";

    public static $datetime = '';

    public static $config = [
        //统一的key
        'account_sid'   => '',
        'account_token' => '',
        'app_id'        => '',
        'server_ip'     => 'sandboxapp.cloopen.com',
        'server_port'   => '8883',
        'soft_version'  => '2013-12-26',
        'date_created'  => ''
    ];

    public static $config_index;

    /**
     * @var RestService
     */
    public static $instance;

    public function __construct($config_index)
    {
        self::$config_index = $config_index;

        self::config();
    }

    /**
     * @param string $config_index
     * @return static
     */
    public static function rest($config_index = 'default')
    {
        if (self::$instance == null) {
            self::$instance = new static($config_index);
        } else if (self::$config_index != $config_index) {
            self::$config_index = $config_index;
            self::config();
        }

        self::$datetime = date("YmdHis");

        return self::$instance;
    }

    private static function config()
    {
        $config = c('rest.' . self::$config_index, []);

        self::$config       = array_merge(self::$config, $config);

        self::$appId        = self::$config['app_id'];

        self::$serverIp     = self::$config['server_ip'];

        self::$serverPort   = self::$config['server_port'];

        self::$softVersion  = self::$config['soft_version'];

        self::$accountSid   = self::$config['account_sid'];

        self::$accountToken = self::$config['account_token'];
    }

    public function sentMessage($to, $data, $tempId)
    {
        if (!self::check()) {
            return false;
        }
        $tempId = self::$config['temp_id'][$tempId];

        $request = [
            'to'         => $to,
            'appId'      => self::$appId,
            'templateId' => intval($tempId),
            'datas'      => $data
        ];
        $request = json_encode($request);

        $sig     = strtoupper(md5(self::$accountSid . self::$accountToken . self::$datetime));

        $url     = "https://" . self::$serverIp . ":" . self::$serverPort . "/" . self::$softVersion . "/Accounts/" . self::$accountSid . "/SMS/TemplateSMS?sig=" . $sig;

        $auth    = base64_encode(self::$accountSid . ":" . self::$datetime);

        $header  = array("Accept:application/json", "Content-Type:application/json;charset=utf-8", "Authorization:$auth");

        $result  = self::curl($url, $request, 1, $header);

        return $result;
    }

    public static function getError()
    {
        return [
            'code' => self::$code,
            'msg'  => self::$msg
        ];
    }

    private static function curl($url, $data = [], $type = 1, $header = [])
    {
        $result = Tool::curl($url, $data, $type, $header);

        self::$code = isset($result['statusCode']) ? $result['statusCode'] : 500;
        self::$msg  = isset($result['statusMsg']) ? $result['statusMsg'] : '';

        if($result['statusCode'] != '000000'){
            return false;
        }

        return true;
    }

    private static function check()
    {
        if (empty(self::$serverIp)) {
            self::$code = '172004';
            self::$msg  = 'IP为空';
            return false;
        }
        if (self::$serverPort <= 0) {
            self::$code = '172005';
            self::$msg  = '端口错误（小于等于0）';
            return false;
        }
        if (empty(self::$softVersion)) {
            self::$code = '172013';
            self::$msg  = '版本号为空';
            return false;
        }
        if (empty(self::$accountSid)) {
            self::$code = '172006';
            self::$msg  = '主帐号为空';
            return false;
        }
        if (empty(self::$accountToken)) {
            self::$code = '172007';
            self::$msg  = '主帐号令牌为空';
            return false;
        }
        if (empty(self::$appId)) {
            self::$code = '172012';
            self::$msg  = '应用ID为空';
            return false;
        }
        return true;
    }
}