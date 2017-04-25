<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/25 15:43
 */
namespace app\admin\controller;

use app\common\controller\HomeLogin;

class Index extends HomeLogin {
    public function index(){
        return $this->fetch('index');
    }
}