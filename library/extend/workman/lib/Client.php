<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/1/25 16:51
 */

namespace library\extend\workman\lib;


use library\extend\workman\exception\ConnectionNotFound;

class Client
{

    /**
     * @param $connect_id
     * @return Connection
     */
    public static function getConnect($connect_id){
        if(!isset(Connect::$client[$connect_id])){
            throw new ConnectionNotFound("$connect_id client not found");
        }

        return Connect::$client[$connect_id];
    }

    public static function getConnectionId(\tpr\framework\Request $request){
        return $request->param('connection_id',null);
    }
}