<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/8/2 上午8:51
 */

namespace library\service;

use tpr\framework\Exception;

/**
 * Class Rong
 * @desc 融云IM服务类
 * @package library\service
 */
class RongService
{
    const   SERVER_API_URL = 'https://api.cn.ronghub.com';    //请求服务地址

    private static $app_key = '';

    private static $app_secret = '';

    private static $format = 'json';

    private static $config = [
        'key' => '',
        'secret' => '',
        'format' => 'json'
    ];

    private static $config_index = 'app.rong';

    public static $msg = '';

    public static $code = 0;

    private static $instance;

    public function __construct($config_index = 'app.rong')
    {
        self::$config_index = $config_index;

        self::config();
    }

    private static function config()
    {
        $config           = c('rong.' . self::$config_index, []);
        self::$config     = array_merge(self::$config, $config);

        self::$app_key    = self::$config['key'];
        self::$app_secret = self::$config['secret'];
        self::$format     = self::$config['format'];
    }

    public static function rong($config_index = 'default')
    {
        if (self::$instance === null) {
            self::$instance = new self($config_index);
        } else if ($config_index != self::$config_index) {
            self::$config_index = $config_index ;
            self::config();
        }
        return self::$instance;
    }

    public function getToken($user_id, $name, $portraitUri = 'default')
    {
        $result = $this->curl('/user/getToken', ['userId' => $user_id, 'name' => $name, 'portraitUri' => $portraitUri]);
        return !$result ? $result : $result['token'];
    }

    public function groupDismiss($user_id, $group_id)
    {
        $data = [
            'userId' => $user_id,
            'groupId' => $group_id
        ];
        $result = $this->curl('/group/dismiss', $data);

        return !$result ? false : true;
    }

    public function groupJoin($user_id, $group_id, $group_name = 'group')
    {
        $data = [
            'userId' => $user_id,
            'groupId' => $group_id,
            'groupName' => $group_name
        ];

        $result = $this->curl('/group/join', $data);

        return !$result ? false : true;
    }

    public function groupUsers($group_id)
    {
        $data = [
            'groupId' => $group_id
        ];

        $result = $this->curl('/group/user/query', $data);

        return !$result ? false : $result;
    }

    private function curl($url, $params = [], $contentType = 'urlencoded')
    {
        try {
            $action = self::SERVER_API_URL . $url . '.' . self::$format;
            $httpHeader = $this->createHttpHeader();
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $action);
            curl_setopt($ch, CURLOPT_POST, 1);
            if ($contentType == 'urlencoded') {
                $httpHeader[] = 'Content-Type:application/x-www-form-urlencoded';
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->build_query($params));
            }
            if ($contentType == 'json') {
                $httpHeader[] = 'Content-Type:Application/json';
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
            }

            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
//            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false); //处理http证书问题
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $ret = curl_exec($ch);

            if (false === $ret) {
                $ret = curl_errno($ch);
            }
            curl_close($ch);

            if (empty($ret)) {
                self::$code = 5001;
                self::$msg = 'request error';
                return false;
            }

            $result = json_decode($ret, true);
            if (is_null($result)) {
                self::$code = 5002;
                self::$msg = 'request error json_decode';
                return false;
            }
            self::$code = $result['code'];

            if (self::$code != 200) {
                self::$msg = $result['errorMessage'];
                return false;
            }
            $ret = $result;
        } catch (Exception $e) {
            self::$code = 5003;
            self::$msg = $e->getMessage();
            return false;
        }

        return $ret;
    }

    private function createHttpHeader()
    {
        $nonce = mt_rand();
        $timeStamp = time();
        $sign = sha1(self::$app_secret . $nonce . $timeStamp);
        return array(
            'RC-App-Key:' . self::$app_key,
            'RC-Nonce:' . $nonce,
            'RC-Timestamp:' . $timeStamp,
            'RC-Signature:' . $sign,
        );
    }

    private function build_query($formData, $numericPrefix = '', $argSeparator = '&', $prefixKey = '')
    {
        $str = '';
        foreach ($formData as $key => $val) {
            if (!is_array($val)) {
                $str .= $argSeparator;
                if ($prefixKey === '') {
                    if (is_int($key)) {
                        $str .= $numericPrefix;
                    }
                    $str .= urlencode($key) . '=' . urlencode($val);
                } else {
                    $str .= urlencode($prefixKey) . '=' . urlencode($val);
                }
            } else {
                if ($prefixKey == '') {
                    $prefixKey .= $key;
                }
                if (is_array($val[0])) {
                    $arr = array();
                    $arr[$key] = $val[0];
                    $str .= $argSeparator . http_build_query($arr);
                } else {
                    $str .= $argSeparator . $this->build_query($val, $numericPrefix, $argSeparator, $prefixKey);
                }
                $prefixKey = '';
            }
        }
        return substr($str, strlen($argSeparator));
    }
}