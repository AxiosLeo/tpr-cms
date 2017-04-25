<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/25 11:03
 */
namespace app\index\middleware;

use axios\tpr\middleware\BaseMiddleware;

class Test extends BaseMiddleware{
    public function index(){
        dump($this->param);
        dump($this->method);
        dump($this->identify);
        dump($this->identify);
    }
}