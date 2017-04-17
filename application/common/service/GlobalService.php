<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/17 10:43
 *
 * Set:  GlobalService::set($name,$value);
 *
 * Get:  GlobalService::get($name);
 *
 * Get:  $Global = new GlobalService();
 *       $Global($name);
 */
namespace app\common\service;
class GlobalService{
    public static function set($name,$value){
        define($name,$value);
    }

    public static function get($name=''){
        if(!defined($name)){
            return false;
        }
        $defined = get_defined_constants(true);
        if(isset($defined['user'][$name])){
            return $defined['user'][$name];
        }
        return "";
    }

    public function __invoke($name='')
    {
        // TODO: Implement __invoke() method.
        return self::get($name);
    }
}