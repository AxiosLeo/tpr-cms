<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 9:45
 */
namespace api\index\controller;

use think\Config;
use think\Controller;
use think\Doc;

class Index extends Controller {
    public function index(){
        $test = new Test();
        $this->response(["hello world!"]);
    }

    public function needName(){
        $this->response(["name"=>$this->param['name']]);
    }

    public function cache()
    {
        sleep(3);
        $this->response(['hello'=>"world","timestamp"=>time()]);
    }

    public function apiDoc(){
        $dir = APP_PATH.'index';
        Doc::config($dir);
        $this->response(Doc::doc());
    }
}