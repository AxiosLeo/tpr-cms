<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/8/2 上午8:51
 */

namespace library\service;

/**
 * Class UmengService
 * @desc 友盟推送服务类
 * @package library\service
 */
class UmengService
{
    // The host
    protected static $host = "http://msg.umeng.com";

    // The upload path
    protected static $uploadPath = "/upload";

    // The post path
    protected static $postPath = "/api/send";

    public static $data = array(
        "appkey" => NULL,
        "timestamp" => NULL,
        "type" => NULL,
        "production_mode" => "false",
    );

    private static $data_keys = [
        "appkey", "timestamp", "type", "device_tokens", "alias",
        "alias_type", "file_id", "filter", "production_mode",
        "feedback", "description", "thirdparty_id", "payload", "policy"
    ];

    public static $code , $msg , $result;

    public static $config_index , $config = [
        'app_key' => '',
        'app_secret' => '',
        'production_mode'=>'false'
    ];

    public static $instance;

    public function __construct($config_index)
    {
        self::$config_index = $config_index;

        self::config();
    }

    public function config()
    {
        $config = c('umeng.' . self::$config_index, []);

        self::$config = array_merge(self::$config, $config);

        self::$data['appkey'] = self::$config['app_key'];

        self::$data['production_mode'] = self::$config['production_mode'];
    }

    public function umeng($config_index = 'default')
    {
        if (self::$instance == null) {
            self::$instance = new static($config_index);
        }

        self::$data['timestamp'] = time();

        return self::$instance;
    }

    private function setData($data = [])
    {
        foreach ($data as $key => $d) {
            if (in_array($key, self::$data_keys)) {
                self::$data[$key] = $d;
            }
        }
        return $this;
    }

    public function send($data)
    {
        $this->setData($data);

        $url = self::$host . self::$postPath;
        $postBody = json_encode(self::$data);
        $sign = md5("POST" . $url . $postBody . self::$config['app_secret']);
        $url = $url . "?sign=" . $sign;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postBody);

        self::$result = curl_exec($ch);
        self::$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        self::$msg = curl_error($ch);
        curl_close($ch);

        if (self::$code != "200") {
            return false;
        }

        return self::$result;
    }

    public function getError()
    {
        $error = [
            'code'   => self::$code,
            'msg'    => self::$msg,
            'result' => self::$result
        ];

        return $error;
    }
}