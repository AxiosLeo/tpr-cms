<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018-12-12 14:22
 */

namespace library\logic;

use api\tool\Http;

class Tool
{
    public static function uuid($salt = '')
    {
        return md5($salt . uniqid(md5(microtime(true)), true));
    }

    public static function uuidAddFlavour($salt = '', $cut = 8, $flavour = '-', $isUpper = false)
    {
        $str    = self::uuid($salt);
        $len    = strlen($str);
        $length = $len;
        $uuid   = '';
        if (is_array($cut)) {
            while ($length > 0) {
                $uuid   .= substr($str, $len - $length, array_rand($cut)) . $flavour;
                $length -= $cut;
            }
        } else if (is_int($cut)) {
            $step = 0;
            while ($length > 0) {
                $temp   = substr($str, $len - $length, $cut);
                $uuid   .= $step != 0 ? $flavour . $temp : $temp;
                $length -= $cut;
                $step++;
            }
        }
        return $isUpper ? strtoupper($uuid) : self::randUpper($uuid);
    }

    /**
     * 获取客户端IP地址
     *
     * @param int  $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param bool $adv  是否进行高级模式获取（有可能被伪装）
     *
     * @return mixed
     */
    public static function getClientIp($type = 0, $adv = false)
    {
        $type = $type ? 1 : 0;
        static $ip = NULL;
        if ($ip !== NULL) return $ip[$type];
        if ($adv) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos = array_search('unknown', $arr);
                if (false !== $pos) unset($arr[$pos]);
                $ip = trim($arr[0]);
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }

    public static function checkData2String(&$array = [])
    {
        if (is_object($array)) {
            $array = self::object2Array($array);
        }
        if (is_array($array)) {
            foreach ($array as &$a) {
                if (is_object($a)) {
                    $a = self::object2Array($a);
                }
                if (is_array($a)) {
                    self::checkData2String($a);
                }
                if (is_int($a)) {
                    $a = strval($a);
                }
                if (is_null($a)) {
                    $a = "";
                }
            }
        } else if (is_int($array)) {
            $array = strval($array);
        } else if (is_null($array)) {
            $array = "";
        }
        return $array;
    }

    public static function object2Array($object)
    {
        $object = json_decode(json_encode($object), true);
        return $object;
    }

    public static function arraySort($array, $sortRule = "", $order = "asc")
    {
        /**
         * $array = [
         *              ["book"=>10,"version"=>10],
         *              ["book"=>19,"version"=>30],
         *              ["book"=>10,"version"=>30],
         *              ["book"=>19,"version"=>10],
         *              ["book"=>10,"version"=>20],
         *              ["book"=>19,"version"=>20]
         *      ];
         */
        if (is_array($sortRule)) {
            /**
             * $sortRule = ['book'=>"asc",'version'=>"asc"];
             */
            usort($array, function ($a, $b) use ($sortRule) {
                foreach ($sortRule as $sortKey => $order) {
                    if ($a[$sortKey] == $b[$sortKey]) {
                        continue;
                    }
                    return (($order == 'desc') ? -1 : 1) * (($a[$sortKey] < $b[$sortKey]) ? -1 : 1);
                }
                return 0;
            });
        } else if (is_string($sortRule) && !empty($sortRule)) {
            /**
             * $sortRule = "book";
             * $order = "asc";
             */
            usort($array, function ($a, $b) use ($sortRule, $order) {
                if ($a[$sortRule] == $b[$sortRule]) {
                    return 0;
                }
                return (($order == 'desc') ? -1 : 1) * (($a[$sortRule] < $b[$sortRule]) ? -1 : 1);
            });
        } else {
            usort($array, function ($a, $b) use ($order) {
                if ($a == $b) {
                    return 0;
                }
                return (($order == 'desc') ? -1 : 1) * (($a < $b) ? -1 : 1);
            });
        }
        return $array;
    }

    /**
     * 随机字符串生成器
     *
     * @param        $length
     * @param string $strPol
     *
     * @return null|string
     */
    public static function getRandChar($length = 15, $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz")
    {
        $str = null;

        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str .= $strPol[rand(0, $max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }

        return $str;
    }

    /**
     * 字符串随机大小写
     *
     * @param $str
     *
     * @return mixed
     */
    public static function randUpper($str)
    {
        $len = strlen($str);
        for ($i = 0; $i < $len; $i++) {
            $str[$i] = mt_rand(0, 1) ? strtoupper($str[$i]) : strtolower($str[$i]);
        }
        return $str;
    }

    public static function curl($url, $data = [], $post = true, $header = [])
    {
        $method   = $post ? "POST" : "GET";
        $response = Http::instance()->setMethod($method)
            ->setParam($data)
            ->setHeader($header)
            ->curl($url);
        return $response;
    }
}