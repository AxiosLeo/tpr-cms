<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/24 14:11
 */
namespace app\common\middleware;

use app\common\service\GlobalService;

class BaseMiddleware {
    protected $param ;

    protected $method ;

    protected $identify ;

    function __construct()
    {
        $this->param = GlobalService::get('param');
        $this->method= GlobalService::get('method');
        $this->identify = GlobalService::get('identify');
    }

    protected function get($name='param'){
        return GlobalService::get($name);
    }
}