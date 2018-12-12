<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018-12-12 14:11
 */

if (!function_exists('data')) {
    function data($data, $index, $default = '')
    {
        return isset($data[$index]) ? $data[$index] : $default;
    }
}

if (!function_exists('c')) {
    function c($index, $default = null)
    {
        return \think\facade\Config::has($index) ? \think\facade\Config::get($index) : $default;
    }
}