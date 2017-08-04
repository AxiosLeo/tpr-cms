<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 9:45
 */

namespace tpr\api\index\controller;

use library\controller\ApiBase;
use think\Doc;

/**
 * Class Index
 * @package api\index\controller
 */
class Index extends ApiBase
{
    /**
     * hello world
     * @desc example
     * @method get
     */
    public function index()
    {
        $this->response(["hello world!"]);
    }

    /**
     * send $name
     * @desc example
     * @method post|get
     */
    public function needName()
    {
        $this->response(["name" => $this->param['name']]);
    }

    /**
     * example for cache
     * @desc example
     * @method get
     */
    public function cache()
    {
        sleep(3);
        $this->response(['hello' => "world", "timestamp" => time()]);
    }

    /**
     * get doc
     * @desc example
     * @method get
     */
    public function apiDoc()
    {
        $dir = APP_PATH . 'index';
        Doc::config($dir);
        $this->response(Doc::doc());
    }

    public function name(){
        $name = $this->request->param('name','name is empty');

        $this->response(['name'=>$name]);
    }
}