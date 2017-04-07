<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/3/27 11:15
 */
namespace app\common\service;

use think\Config;

class LangService {

    public static function trans($message){
        $error = explode('@', $message);
        $str = '';
        foreach ($error as $e){
            $tmp = lang($e);
            if($e===$tmp){
                $str.=lang($e)." ";
            }else{
                $str.=lang($e);
            }
        }
        return $str;
    }

    public static function message($code){
        if(Config::has('code.'.$code)){
            $message = Config::get("code.".$code);
            return LangService::trans($message);
        }else{
            return "";
        }
    }
}