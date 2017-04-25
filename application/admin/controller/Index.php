<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/25 15:43
 */
namespace app\admin\controller;

use app\common\controller\HomeBase;

class Index extends HomeBase {
    public function index(){
        return $this->fetch('index');
    }
}