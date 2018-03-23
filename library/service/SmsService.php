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

use aliyun\sdk\sms\Sms;
use think\Config;

class SmsService
{

    public static $instance;

    public static $config_index = 'app.aliyun_message';

    public static $config = [
        'accessKeyId' => '',
        'accessSecret' => '',
        'signName' => '',
        'templateCode' => [

        ]
    ];

    /**
     * @var Sms $sms
     */
    private static $sms;

    private static $template = [];

    public static function instance($config_index = 'app.aliyun_message')
    {
        date_default_timezone_set('PRC');

        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        if (self::$config_index != $config_index) {
            self::$config_index = $config_index;
        }

        self::$config = array_merge(self::$config, Config::get($config_index,[]));
        self::$sms = Sms::factory(self::$config['accessKeyId'], self::$config['accessSecret']);
        self::$template = self::$config['templateCode'];

        return self::$instance;
    }

    public function sendCode($mobile, $code, $template = 'code', $code_key = 'name')
    {
        if (isset(self::$template[$template])) {
            $param = [$code_key => $code];
            $this->sendMessage($mobile,'code',$param);
            return true;
        }
        return false;
    }

    public function sendMessage($mobile, $template, $param = [])
    {
        if (isset(self::$template[$template])) {
            self::$sms->setPhoneNumbers($mobile)
                ->setTemplateCode(self::$template[$template])
                ->setTemplateParam($param)
                ->setSignName(self::$config['signName'])
                ->send();
            return true;
        }
        return false;
    }
}