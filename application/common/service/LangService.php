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
use think\Lang;

class LangService extends Lang{

    public static function trans(){
        return new self();
    }
    public function message($code){
        $message = Config::get("code.".$code);
        return Lang::get($message);
    }
}