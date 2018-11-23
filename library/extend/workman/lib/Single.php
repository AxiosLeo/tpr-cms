<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    :  http://hanxv.cn
 * @datetime: 2018/1/25 15:52
 */

namespace library\extend\workman\lib;


class Single
{
    public static function send($connect_id, $data)
    {
        Client::getConnect($connect_id)->send($data);
    }
}