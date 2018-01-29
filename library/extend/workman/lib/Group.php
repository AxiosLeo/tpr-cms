<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/1/25 15:44
 */

namespace library\extend\workman\lib;


class Group
{
    /**
     * @param array $connections
     * @param array $data
     */
    public static function send(array $connections,$data){
        foreach ($connections as $connection_id){
            Single::send($connection_id,$data);
        }
    }
}