<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/9/18 下午2:37
 */

namespace tpr\api\example\controller;

use tpr\framework\Controller;

/**
 * Example/Index
 * @package tpr\api\example\controller
 */
class Index extends Controller
{
    /**
     * test
     * @parameter string name 名称
     * @parameter int age 年龄
     * @header x-action exampleApiHeader
     */
    public function index(){
        $this->response([
            "message"=>'this is example!',
            "param"=>$this->request->param(),
            "post"=>$this->request->post(),
            "get"=>$this->request->get()
        ]);
    }
}