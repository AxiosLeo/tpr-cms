<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/8/28 下午1:36
 */

if(!function_exists('get_avatar')){
    function get_user_avatar($avatar = null){
        if(empty($avatar)){
            $avatar = user_info('avatar');
        }
        return !empty($avatar) && file_exists(ROOT_PATH . 'public/' . $avatar) ? $avatar : '/src/images/avatar.png';
    }
}

if(!function_exists('rand_upper')){
    function rand_upper($str){
        $len = strlen($str);
        for ($i=0 ; $i<$len; $i++){
            $str[$i] = mt_rand(0,1) ? strtoupper($str[$i]) : strtolower($str[$i]);
        }
        return $str;
    }
}