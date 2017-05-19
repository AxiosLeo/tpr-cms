<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/18 13:38
 */
namespace admin\user\controller;

use admin\common\controller\HomeBase;

class Profile extends HomeBase{
    public function index(){
        return $this->fetch('index');
    }
}