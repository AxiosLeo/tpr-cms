<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/8/28 下午1:36
 */

if (!function_exists('is_user_login')) {
    function is_user_login($prefix = PROJECT_NAME)
    {
        $user = \think\Session::has($prefix . '_user');
        return empty($user) ? false : true;
    }
}

if(!function_exists('clear_user_login')){
    function clear_user_login($prefix = PROJECT_NAME){
        \think\Session::delete($prefix . '_user');
        return true;
    }
}

if (!function_exists('user_info')) {
    function user_info($field = '',$prefix = PROJECT_NAME)
    {
        $user = \think\Session::get($prefix . '_user');
        if (empty($field)) {
            return $user;
        }
        $data = [];
        if (is_string($field)) {
            if (strpos($field, ',')) {
                $keys = explode(',', $field);
                foreach ($keys as $k) {
                    $data[$k] = data($user, $k);
                }
            } else {
                return data($user, $field);
            }
        } elseif (is_array($field)) {
            foreach ($field as $k) {
                $data[$k] = data($user, $k);
            }
        }
        $user = $data;
        return $user;
    }
}

if (!function_exists('user_save')) {
    function user_save($user,$prefix = PROJECT_NAME)
    {
        \think\Session::set($prefix . '_user', $user);
    }
}

if (!function_exists('user_current_id')) {
    function user_current_id($id_index = 'id',$prefix = PROJECT_NAME)
    {
        return user_info($id_index, $prefix);
    }
}

if (!function_exists('getLastUrl')) {
    function getLastUrl()
    {
        return \think\Session::get('last_url');
    }
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