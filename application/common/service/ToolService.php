<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/15 14:43
 */
namespace app\common\service;

class ToolService {
    public static function uuid($salt=''){
        $str = md5($salt.uniqid(md5(microtime(true)),true));
        $uuid = substr($str, 0, 8)."-".substr($str, 8, 8)."-".substr($str,16,8)."-".substr($str,24,8);
        return $uuid;
    }
}