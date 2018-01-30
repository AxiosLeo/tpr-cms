<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 11:30
 */

if (!function_exists('is_user_login')) {
    function is_user_login($prefix = PROJECT_NAME)
    {
        $user = \think\Session::has($prefix . '_user');
        return empty($user) ? false : true;
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

function make_password($password, $auth = '')
{
    return md5($auth . $password);
}

if (!function_exists('data')) {
    /**
     * @param $array
     * @param $index
     * @param string $default
     * @return string|array
     */
    function data($array, $index, $default = '')
    {
        return isset($array[$index]) ? $array[$index] : $default;
    }
}

if (!function_exists('get_day_begin_end_time')) {
    function get_day_begin_end_time($date, $format = 'timestamp')
    {
        $begin = strtotime($date . " 00:00:00");
        $end = strtotime("$date +1 day -1 seconds");
        if ($format == 'timestamp') {
            return [
                'begin' => $begin,
                'end' => $end
            ];
        } else {
            return [
                'begin' => date($format, $begin),
                'end' => date($format, $end),
            ];
        }
    }
}

if (!function_exists('trans2time')) {
    function trans2time($timestamp, $format = "Y-m-d H:i:s", $default = '')
    {
        $result = !empty($timestamp) ? @date($format, $timestamp) : $default;

        return $result != "1970-01-01 08:33:37" ? $result : '';
    }
}

if(!function_exists('getDayBeginEndTime')){
    function getDayBeginEndTime($date,$format='timestamp'){
        $begin = strtotime($date." 00:00:00");
        $end   = strtotime("$date +1 day -1 seconds");
        if($format=='timestamp'){
            return [
                'begin'=>$begin,
                'end'=>$end
            ];
        }else{
            return [
                'begin'=>date($format,$begin),
                'end'=>date($format,$end),
            ];
        }
    }

}