<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/19 17:04
 */
namespace tpr\admin\user\controller;

use tpr\admin\common\controller\AdminLogin;

class Log extends AdminLogin{
    /**
     * 个人日志
     * @return mixed
     */
    public function index(){
        return $this->fetch('index');
    }
}