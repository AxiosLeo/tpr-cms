<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    :  http://hanxv.cn
 * @datetime: 2018/1/25 16:56
 */

namespace library\extend\workman\lib;

use Workerman\Connection\TcpConnection;

abstract class Connection extends TcpConnection
{
    public $connection_id = null;
}