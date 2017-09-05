<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 11:30
 */

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
