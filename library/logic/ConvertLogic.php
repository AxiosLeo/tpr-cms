<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/1/15 14:27
 */

namespace library\logic;

/**
 * 进制转换器
 * BHD Converter
 * @package library\logic
 */
class ConvertLogic
{
    public static $index = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

    public static function convert($str, $from, $to, $min_length = null)
    {
        if ($from !== 10) {
            $fromBase = self::convertTo10($str, $from);
        } else {
            $fromBase = $str;
        }

        $toBase = self::convert10($fromBase, $to);

        if (!is_null($min_length)) {
            $strLength = strlen($toBase);
            while ($strLength < $min_length) {
                $toBase = "0" . $toBase;
                $strLength++;
            }
        }

        return $toBase;
    }

    private static function convert10($num, $to = 62)
    {
        $dict = self::$index;
        $ret = '';
        do {
            $ret = $dict[bcmod($num, $to)] . $ret;
            $num = bcdiv($num, $to);
        } while ($num > 0);
        return $ret;
    }

    private static function convertTo10($num, $from = 62)
    {
        $num = strval($num);
        $dict = self::$index;
        $len = strlen($num);
        $dec = 0;
        for ($i = 0; $i < $len; $i++) {
            $pos = strpos($dict, $num[$i]);
            $dec = bcadd(bcmul(bcpow($from, $len - $i - 1), $pos), $dec);
        }
        return $dec;
    }

}