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
        return md5($salt.uniqid(md5(microtime(true)),true));
    }

    public static function uuidAddFlavour($salt='',$cut=8,$flavour='-',$isUpper=false){
        $str = self::uuid($salt);
        $len = strlen($str);$length = $len;$uuid='';
        if(is_array($cut)){
            while ($length>0){
                $uuid .= substr($str,$len-$length,array_rand($cut)).$flavour;
                $length -=$cut;
            }
        }else if(is_int($cut)){
            $step = 0;
            while ($length>0){
                $temp = substr($str,$len-$length,$cut);
                $uuid .= $step!=0 ? $flavour.$temp:$temp;
                $length -=$cut;
                $step++;
            }
        }
        return $isUpper?strtoupper($uuid):$uuid;
    }
}