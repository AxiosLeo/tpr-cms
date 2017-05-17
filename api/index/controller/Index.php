<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 9:45
 */
namespace api\index\controller;

use axios\tpr\core\Api;
use axios\tpr\service\ApiDocService;

class Index extends Api {
    public function index(){
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
        $this->response(ApiDocService::api());
    }
}