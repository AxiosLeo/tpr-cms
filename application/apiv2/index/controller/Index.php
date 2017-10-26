<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/8/23 16:38
 */
namespace tpr\apiv2\index\controller;

use think\Controller;

class Index extends Controller{

    public function index(){
        $this->response($this->request->param());
    }
}