<?php
namespace app\index\controller;

use axios\tpr\controller\ApiBase;
use axios\tpr\service\ApiDocService;
use axios\tpr\service\MongoService;
/**
 * 接口类名
 * @desc 接口类描述
 * @package app\index\controller
 */
class Index extends ApiBase
{
    /**
     * 接口名称
     * @desc 接口描述
     * @method post | get
     * @parameter 参数类型 参数名称
     * @response string param_name param_info
     */
    public function index()
    {
        $this->response(['name'=>"hello world1"]);
    }

    /**
     * hello
     * @desc 测试接口
     * @method get
     */
    public function hello()
    {
        $this->response(['hello'=>"world",'test'=>"a"]);
    }

    public function doc(){
        $this->response(ApiDocService::api());
    }

    public function test(){
        $this->response("hello");
    }

    public function mongo(){
        $Mongo = MongoService::name('test');
        dump($Mongo);

        $data = $Mongo->select();
        dump($data);

        $Mongo->insertGetId(['timestamp'=>"123"]);
        dump($Mongo->select());

        $Mongo->where('timestamp',"123")->delete();
        dump($Mongo->select());
    }
}