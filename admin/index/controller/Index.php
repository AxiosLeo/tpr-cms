<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 10:10
 */
namespace admin\index\controller;

use admin\common\controller\HomeLogin;

class Index extends HomeLogin {
    public function index(){
        $this->assign('menu',$this->menu());
        return $this->fetch('index');
    }

    public function main(){
        return $this->fetch('main');
    }
}