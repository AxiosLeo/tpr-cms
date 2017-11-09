<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/10/25 上午10:35
 */

namespace tpr\workman\index\controller;

use think\Controller;

class Index extends Controller
{
    public function index(){
        $this->response($this->request->param());
    }
}