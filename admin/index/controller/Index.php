<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 10:10
 */
namespace admin\index\controller;

use admin\common\controller\HomeBase;

class Index extends HomeBase {
    public function index(){
        return $this->fetch('index');
    }
}