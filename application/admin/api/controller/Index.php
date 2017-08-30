<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/8/30 下午3:14
 */
namespace tpr\admin\api\controller;

use tpr\admin\common\controller\AdminLogin;

class Index extends AdminLogin{
    public function index(){
        return $this->fetch();
    }
}