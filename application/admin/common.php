<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/8/28 下午1:36
 */

function is_user_login(){
    $user = \think\Session::has('user');
    return  empty($user) ? false:true;
}

function user_info($field = ''){
    $user = \think\Session::get('user');
    if(empty($field)){
        return $user;
    }
    $data = [];
    if(is_string($field)){
        if(strpos($field , ',')){
            $keys = explode(',' , $field);
            foreach ($keys as $k){
                $data[$k] = data($user,$k);
            }
        }else{
            return data($user,$field);
        }
    }elseif(is_array($field)){
        foreach ($field as $k){
            $data[$k] = data($user,$k);
        }
    }
    $user = $data;
    return $user;
}

function user_current_id(){
    $user = user_info();
    return $user['id'];
}

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