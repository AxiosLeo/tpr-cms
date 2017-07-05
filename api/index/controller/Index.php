<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 9:45
 */
namespace api\index\controller;

use think\Controller;
use think\Doc;

/**
 * Class Index
 * @package api\index\controller
 */
class Index extends Controller {
    /**
     * hello world
     */
    public function index(){
        $this->response(["hello world!"]);
    }

    /**
     * send $name
     */
    public function needName(){
        $this->response(["name"=>$this->param['name']]);
    }

    /**
     * example for cache
     */
    public function cache()
    {
        sleep(3);
        $this->response(['hello'=>"world","timestamp"=>time()]);
    }

    /**
     * get doc
     */
    public function apiDoc(){
        $dir = APP_PATH.'index';
        Doc::config($dir);
        $this->response(Doc::doc());
    }
}