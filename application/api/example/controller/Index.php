<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/9/18 下午2:37
 */

namespace tpr\api\example\controller;

use think\Controller;

/**
 * Example/Index
 * @package tpr\api\example\controller
 */
class Index extends Controller
{
    /**
     * test
     */
    public function index(){
        $this->response('this is example!');
    }
}